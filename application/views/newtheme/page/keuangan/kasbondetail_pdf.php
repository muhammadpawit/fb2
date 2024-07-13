<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Kas Bon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-transform: capitalize;
        }
        .kas-bon {
            width: 100%;
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
        }
        .kas-bon h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .row div {
            flex: 1;
            margin-right: 10px;
        }
        .row div:last-child {
            margin-right: 0;
        }
        .wide {
            width: 100%;
            display: inline-block;
        }
        .terbilang {
            height: 50px;
            border: 1px solid #000;
            display: inline-block;
            width: calc(100% - 100px);
            vertical-align: top;
            margin-left: 5px;
        }
        .box {
            border: 1px solid #000;
            height: 30px;
            display: inline-block;
            width: calc(100% - 60px);
            vertical-align: top;
            margin-left: 5px;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signature div {
            text-align: center;
            width: 30%;
            border: 1px solid #000;
            height: 50px;
            padding-top: 30px;
        }
        .sign-section {
            margin-bottom: 10px;
        }
        .break{ page-break-after: always; }
        .ket {
            font-size: 10px;
        }
    </style>
</head>
<body>
<?php 
$no = 1; // Initialize counter
$totalItems = count($detail); // Total number of items in $detail array

// Loop through each $d in $detail array
foreach($detail as $d) {
    ?>
      <div class="kas-bon">
        <h1><i>NOTA KASBON FORBOYS</i></h1><hr>
        <div class="row">
            <div style="width: 70%;">Nama : <span class="wide"><b><?php echo $d['nama']?></b></span></div>
            <div style="width: 30%; float: right;">Tanggal : <span class="wide"><b><?php echo $d['tanggal']?></b></span></div>
        </div><hr><br>
        <div class="row">
          <div style="border: 1px solid black; width: 30%; padding: 30px; font-size: 30px;">
            Rp. <?php echo number_format($d['nominal_acc'])?>
          </div>
          <div style="float: right; width: 55%; font-size: 30px;">
              <i><?php echo strtolower($d['terbilang']) ?> Rupiah</i><hr><hr><hr>
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="ket">
            <fieldset>Keterangan : <?php echo $d['keterangan']?></fieldset>
        </div>
       <div class="row">
        <div style="width:45%;text-align:center;margin-left:400px">
          Yang Menerima,<?php for($i=1;$i<=5;$i++){ echo "<br>"; }?>(........................)
          <div style="clear: both;"></div><br>
          <small>
          <i>
            Waktu Cetak : <?php echo date('d/m/Y H:i:s') ?>
          </i>
          </small>
        </div>
        
       </div>

      </div>

    </div>
    <div style="clear: both;"></div>
    <br><br>
    
    <?php 
    // Check if $no is divisible by 3 and not the last item
    if ($no % 2 == 0 && $no !== $totalItems) { 
        ?>
        <div class="break"></div>
        <?php 
    }
    
    $no++; // Increment counter
}
?>

</body>
</html>
