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
              <h2>App Name</h2>
              <p><strong>selangkung.com</strong></p>
            </div>
          </div><!--/col-->

        </div><!--/row-->
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th class="center">#</th>
              <th>Item</th>
              <th>Description</th>
              <th class="center">Quantity</th>
              <th class="right">Unit Cost</th>
              <th class="right">Total</th>                                          
            </tr>
          </thead>   
          <tbody>
            <tr>
              <td class="center">1</td>
              <td class="left">Genius License</td>
              <td class="left">Extended License</td>
              <td class="center">1</td>
              <td class="right">$999,00</td>
              <td class="right">$999,00</td>                                        
            </tr>
            <tr>
              <td class="center">2</td>
              <td class="left">Custom Services</td>
              <td class="left">Instalation and Customization (cost per hour)</td>
              <td class="center">20</td>
              <td class="right">$150,00</td>
              <td class="right">$3.000,00</td>                                        
            </tr>
            <tr>
              <td class="center">3</td>
              <td class="left">Hosting</td>
              <td class="left">1 year subcription</td>
              <td class="center">1</td>
              <td class="right">$499,00</td>
              <td class="right">$499,00</td>                                        
            </tr>
            <tr>
              <td class="center">4</td>
              <td class="left">Platinum Support</td>
              <td class="left">1 year subcription 24/7</td>
              <td class="center">1</td>
              <td class="right">$3.999,00</td>
              <td class="right">$3.999,00</td>                                        
            </tr> 
            <tr>
              <td class="center" colspan="5">Sub Total</td>
              <td class="right">$3.999,00</td>                                        
            </tr> 
            <tr>
              <td class="center" colspan="5">Total</td>
              <td class="right">$3.999,00</td>                                        
            </tr>                                 
          </tbody>
        </table>

        <div class="row">

          <div class="col-lg-4 col-sm-5 notice">
            <div class="well">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </div>  
          </div><!--/col-->

        </div><!--/row-->

      </div>
  </body>
</html>