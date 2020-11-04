<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sample Invoice</title>
    <link rel="stylesheet" href="<?=public_path()?>/dist/assets/bootstrap/css/bootstrap.css">
    <style>
      body, h1, h2, h3, h4, h5, h6{
      font-family: 'Bree Serif', serif;
      }
    </style>
  </head>
  
  <body>
<div class="invoice">
        
        <div class="row header">

          <div class="col-sm-2">
            <div class="well" style="min-height: 19px;padding: 5px;">
              <h2>Inventory</h2>
              <p><strong>Struk Pembelian</strong></p>
            </div>
          </div><!--/col-->

        </div><!--/row-->
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th class="center">#</th>
              <th>Item</th>
              <th class="center">Quantity</th>
              <th class="right">Unit Cost</th>
              <th class="right">Total</th>                                          
            </tr>
          </thead>   
          <tbody>
            <?php $grantT=0; ?>
            @foreach($row as $key => $value)
              @foreach($value->detail as $keyVal => $valueVal)
              <tr>
                <td class="center">{{$keyVal+1}}</td>
                <td class="left">{{$valueVal->item->name}}</td>
                <td class="right">{{$valueVal->qty}}</td>
                <td class="center">{{GlobalHelper::formatCurrency((int)$valueVal->item->pricelist->selling_price)}}</td>
                <td class="right">{{GlobalHelper::formatCurrency((int)$valueVal->amount)}}</td>                                        
              </tr>
              <?php $grantT+=$valueVal->amount; ?>
              @endforeach
            @endforeach
            <tr>
              <td class="center" colspan="4">Total</td>
              <td class="right">{{GlobalHelper::formatCurrency($grantT)}}</td>                                        
            </tr>                                 
          </tbody>
        </table>

        <div class="row">

          <div class="col-lg-4 col-sm-5 notice">
            <div class="well">
              Catatan
            </div>  
          </div><!--/col-->

        </div><!--/row-->

      </div>
  </body>
</html>