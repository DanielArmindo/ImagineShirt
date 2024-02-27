<style>
    .card-gradient-blue {
        background: linear-gradient(to right, #009dff, #3a6bd5);
    }

    .card-gradient-green {
        background: linear-gradient(to right, #0ba360, #3cba8c);
    }

    .card-gradient-purple {
        background: linear-gradient(to right, #f2be64, #ffac06);
    }
    .card-gradient-red {
        background: linear-gradient(to right, #f26464, #ff1f06);
    }
</style>


<div class="d-flex justify-content-around p-5">
    <div class="card card-gradient-red" style="width: 14rem;">
        <div class="card-body">
            <h3 class=" text-white"><i class=" card-title fi-rs-dollar"></i></h3>
            <p class="card-title text-white">Total Faturado</p>
            <h3 class="card-text text-white">{{$totalPrice}}€</h3>
        </div>
    </div>
    <div class="card card-gradient-blue " style="width: 14rem;">
        <div class="card-body">
            <h3 class=" text-white"><i class=" card-title fi-rs-shopping-cart"></i></h3>
            <p class="card-title text-white">Total de Encomendas</p>
            <h3 class="card-text text-white">{{$totalClosed}}</h3>
        </div>
    </div>


    <div class="card card-gradient-green" style="width: 14rem;">
        <div class="card-body">
            <h3 class=" text-white"><i class=" card-title fi-rs-shopping-bag"></i></h3>
            <p class="card-title text-white">Total de Produtos</p>
            <h3 class="card-text text-white">{{$totalProducts}}</h3>
        </div>
    </div>

    <div class="card card-gradient-purple" style="width: 14rem;">
        <div class="card-body">
            <h3 class=" text-white"><i class=" card-title fi-rs-user"></i></h3>
            <p class="card-title text-white">Total de Clientes</p>
            <h3 class="card-text text-white">{{$usersCount}}</h3>

        </div>
    </div>

</div>
<div class="d-flex justify-content-around p-5">
    <div class="col-md-3 ">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-md-3 ">
        <canvas id="myChart3"></canvas>
    </div>

  </div>

  <div class="d-flex justify-content-around p-5">
    <div class="col-md-6">
        <canvas id="myChart2"></canvas>
    </div>


  </div>

  <div class="d-flex justify-content-around p-5">
    <div class="col-md-3">
        <canvas id="myChart4"></canvas>
    </div>
    <div class="col-md-3">
        <canvas id="precoMes"></canvas>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [{{$ano}}],
        datasets: [{
          label: 'Orders per Year',
          data: [{{$total}}],
          borderWidth: 1
        }]
      },
      options: {

        plugins: {
          title: {
            display: true,
            text: 'Orders per Year'
          }
      }
      }
    });

    const ctx2 = document.getElementById('myChart2');

new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: [{{$anoCustomer}}],
    datasets: [{
      label: 'Customers per Year',
      data: [{{$totalCustomer}}],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const ctx3 = document.getElementById('myChart3');

    new Chart(ctx3, {
      type: 'pie',
      data: {
        labels: [{{$mesvendas}}],
        datasets: [{
          label: 'Orders per Month this Year',
          data: [{{$totalMonthvendas}}],
          borderWidth: 1
        }]
      },
      options: {

        plugins: {
          title: {
            display: true,
            text: 'Orders per Month this Year'
          }
      }
      }
    });

    const ctx4 = document.getElementById('myChart4');

    new Chart(ctx4, {
      type: 'pie',
      data: {
        labels: [{{$anoPrice}}],
        datasets: [{
          label: 'Sales per Year (€)',
          data: [{{$totalYearPrice}}],
          borderWidth: 1
        }]
      },
      options: {

        plugins: {
          title: {
            display: true,
            text: 'Sales per Year (€)'
          }
      }
      }
    });


    const ctx5 = document.getElementById('precoMes');

    new Chart(ctx5, {
      type: 'pie',
      data: {
        labels: [{{$mesPrice}}],
        datasets: [{
          label: 'Sales per Month this Year (€)',
          data: [{{$totalMonthPrice}}],
          borderWidth: 1
        }]
      },
      options: {

        plugins: {
          title: {
            display: true,
            text: 'Sales per Month this Year (€)'
          }
      }
      }
    });
  </script>
