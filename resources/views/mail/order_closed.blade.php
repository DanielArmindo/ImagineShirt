<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Email</title>
    <style>
        .container {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
        }
        .btn{
            color: orange;
        }
        .btn:hover {
            background-color: orange;
            border-color: orange;
            color: white;
        }
      </style>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <img src="{{asset('/assets/imgs/logo/logo2.png')}}" alt="Logo" width="300">
            <p>Dear {{$name}},</p>
            <p>{{$info}}</p>
            <p>We send you a proof of your purchase</p>
            <a href="{{$url}}" style="margin-top: 10px;margin-bottom:10px;border-color: orange;" class="btn btn-sm btn-outline-primary">Link to PDF</a>
            <p>{{$info2[0]}} <a href="{{$info2[2]}}">{{$info2[1]}}</a></p>
            <p>Best regards, <span style="font-weight: bold">Imagine Shirt</span></p>
          </div>
        </div>
      </div>
</body>
</html>
