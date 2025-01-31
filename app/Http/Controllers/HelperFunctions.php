<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class HelperFunctions extends Controller
{
    public function merge($tshirt, $logo)
    {
        $camisola = storage_path('app/public/tshirt_base/' . $tshirt);
        $estampa = storage_path('app/public/tshirt_images/' . $logo);

        $dest = imagecreatefromjpeg($camisola);

        try {
            $src = imagecreatefrompng($estampa);
        } catch (\Throwable $th) {
            $src = @imagecreatefrompng($estampa);
        }

        $this::show_image($src, $dest);
    }

    public function merge64($tshirt, $estampa, $flag)
    {

        $camisola = storage_path('app/public/tshirt_base/' . $tshirt);

        $url = 'tshirt_images_private/' . $estampa;
        if (Storage::exists($url)) {
            $content = Storage::get($url);
        } else {
            back();
        }

        $dest = imagecreatefromjpeg($camisola);

        $src = imagecreatefromstring($content);

        $this::show_image($src, $dest, $flag);
    }

    public static function show_image($src, $dest, $flag = 1)
    {
        // Tamanho da logo
        $new_width = 200;
        $new_height = 200;

        //Posição da logo na t-shirt
        $x = 150;
        $y = 100;

        $src = imagescale($src, $new_width, $new_height);

        imagecopymerge($dest, $src, $x, $y, 0, 0, $new_width, $new_height, 100);

        /*$white = imagecolorallocate($src, 0, 0, 0);
        imagecolortransparent($dest, $white);*/

        if ($flag == 2) {
            //correção da imagem
            $oldColor = imagecolorallocate($dest, 0, 0, 0);
            $newColor = imagecolorallocate($dest, 255, 255, 255);

            $width = imagesx($dest);
            $height = imagesy($dest);

            //Converte background preto para branco
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $pixelColor = imagecolorat($dest, $x, $y);

                    if ($pixelColor === $oldColor) {
                        imagesetpixel($dest, $x, $y, $newColor);
                    }
                }
            }
        }

        if ($flag == 3) {
            ob_start();
            imagepng($dest);
            $imageData = ob_get_contents();
            ob_end_clean();

            $base64Image = base64_encode($imageData);
            imagedestroy($dest);
            imagedestroy($src);

            return $base64Image;
        }

        header('Content-Type: image/png');

        imagepng($dest);

        imagedestroy($dest);
        imagedestroy($src);
    }


    public static function get_tshirts($dados)
    {
        $tshirts = array();
        $cont = 0;
        foreach ($dados as $file) {
            array_push($tshirts, [asset('/storage/tshirt_base/' . $file->code . '.jpg') => $file->code . ".jpg"]);
            $cont++;
        }

        return $tshirts;
    }

    //Exporta o pdf para a storage do carrinho
    public static function export_to_PDF($id, $name, $nif, $payment)
    {
        $carrinho = Cart::content();
        $fileName = $id . "-" . Str::uuid()->toString() . '.pdf';
        $path = storage_path('app/pdf_receipts');

        try {
            // Transformar imagens em base64Image da encomenda
            $images_urls = [];
            foreach ($carrinho as $item) {
                $url = $item->options->image_url;
                array_push($images_urls, $url);
            }

            $images = self::getImagesBase64($images_urls);

            // Prepara dados para enviar
            $data = [
                'carrinho' => $carrinho,
                'total' => Cart::total(),
                'data' => date('Y-m-d'),
                'nif' => $nif,
                'nome' => $name,
                'payment' => $payment,
                'images' => $images,
            ];

            $template = view('livewire.recibo-component', $data)->render();

            Browsershot::html($template)
                ->setNodeBinary(env('NODE_BINARY_PATH'))
                ->setNpmBinary(env('NPM_BINARY_PATH'))
                ->noSandbox()
                ->save($path . "/" . $fileName);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $fileName;
    }

    //Quando não existe existe PDFs cria um novo e devolve o nome
    public static function not_exist_PDF($order, $order_items)
    {

        $images = array();
        foreach ($order_items as $item) {
            $tshirt = $item->color_code . '.jpg';

            if ($item->tshirt_imageRef->customer_id == null) {
                $url = route('merge_tshirt', ['tshirt' => $tshirt, 'estampa' => $item->tshirt_imageRef->image_url]);
                array_push($images, $url);
            } else {

                $back = 1;
                try {
                    $back = json_decode($item->tshirt_imageRef->extra_info, true);
                    $back = intval($back['background']);
                } catch (\Throwable $th) {
                    $back = 1;
                }

                $url = route('merge_imageb64', ['background' => $back, 'tshirt' => $tshirt, 'estampa' => $item->tshirt_imageRef->image_url]);
                array_push($images, $url);
            }
        }

        $data = [
            'order_items' => $order_items,
            'images' => $images,
            'status' => $order->status,
            'total' => $order->total_price,
            'data' => $order->date,
            'nif' => $order->nif,
            'nome' => $order->customerRef->userRef->name,
            'payment' => $order->payment_type,
        ];

        $fileName = $order->id . "-" . Str::uuid()->toString() . '.pdf';
        $template = view('livewire.recibo-component', $data)->render();
        $path = storage_path('app/pdf_receipts');

        Browsershot::html($template)
            ->setNodeBinary(env('NODE_BINARY_PATH'))
            ->setNpmBinary(env('NPM_BINARY_PATH'))
            ->noSandbox()
            ->save($path . "/" . $fileName);

        return $fileName;
    }

    //Quando o admin ou o funcionário trocam o status da order para closed
    public static function replace_order_pdf(order $order)
    {
        $url_image = $order->receipt_url == null ? '(nao existe)' : $order->receipt_url;
        $url = 'pdf_receipts/' . $url_image;

        if (Storage::exists($url)) {
            Storage::delete('pdf_receipts/' . $order->receipt_url);
        }
        $name_pdf = HelperFunctions::not_exist_PDF($order, $order->orderitemRef);
        $order->receipt_url = $name_pdf; //Ficheiro para o pdf
        $order->save();
    }

    public static function show_pdf(order $order)
    {
        $images = array();
        foreach ($order->orderitemRef as $item) {
            $tshirt = $item->color_code . '.jpg';

            if ($item->tshirt_imageRef->customer_id == null) {
                $url = route('merge_tshirt', ['tshirt' => $tshirt, 'estampa' => $item->tshirt_imageRef->image_url]);
                array_push($images, $url);
            } else {

                $back = 1;
                try {
                    $back = json_decode($item->tshirt_imageRef->extra_info, true);
                    $back = intval($back['background']);
                } catch (\Throwable $th) {
                    $back = 1;
                }

                $url = route('merge_imageb64', ['background' => $back, 'tshirt' => $tshirt, 'estampa' => $item->tshirt_imageRef->image_url]);
                array_push($images, $url);
            }
        }

        $data = [
            'order_items' => $order->orderitemRef,
            'images' => self::getImagesBase64($images),
            'status' => $order->status,
            'total' => $order->total_price,
            'data' => $order->date,
            'nif' => $order->nif,
            'nome' => $order->customerRef->userRef->name,
            'payment' => $order->payment_type,
        ];

        $template = view('livewire.recibo-component', $data)->render();

        $pdfContent = Browsershot::html($template)
            ->setNodeBinary(env('NODE_BINARY_PATH'))
            ->setNpmBinary(env('NPM_BINARY_PATH'))
            ->noSandbox()
            ->pdf();

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="recibo.pdf"');
    }

    private static function getImagesBase64($images)
    {
        $base64Images = [];
        foreach ($images as $url) {
            $parts = explode('/', $url);
            $tshirt = isset($parts[4]) ? $parts[4] : null;
            $logo = isset($parts[5]) ? $parts[5] : null;

            $camisola = storage_path('app/public/tshirt_base/' . $tshirt);
            $estampa = count($parts) == 7 ? storage_path('app/tshirt_images_private/' . $logo) : storage_path('app/public/tshirt_images/' . $logo);

            $dest = imagecreatefromjpeg($camisola);

            try {
                $src = imagecreatefrompng($estampa);
            } catch (\Throwable $th) {
                $src = @imagecreatefrompng($estampa);
            }

            $response = self::show_image($src, $dest, 3);
            array_push($base64Images, $response);
        }

        return $base64Images;
    }
}
