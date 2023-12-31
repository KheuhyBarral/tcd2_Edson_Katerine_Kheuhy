<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isCliente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20cliente.');
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa Di Fugassa | Restaurante IFNMG</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/cabecario.inq.php")
    ?>
    <main>
        <h2>Seu histórico de compras</h2>
        <?php
        require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/compra.class.php";

        $compras = Compra::comprasCliente($_SESSION["id"]);

        $r = "<table><tr>
        <th>Data</th>
        <th>Vendedor</th>
        <th>Valor total</th>
        <th>Valor pago</th>
        <th>Dívida</th>
        <th>Detalhes</th>
        </tr>";
    
    $total = 0;
    foreach($compras as $c)
    {
      $data = $c->data;
      $vendedor = Util::getClient($c->vendedor_id);
      $valor_total = $c->valor;
      $valor_pago = $c->valor_pago;
      $divida = $valor_total - $valor_pago;
      $total += $divida;
      
      $r .= "<tr> <td>" . $data . "</td>"; 
      $r .= "<td>" . $vendedor . "</td>"; 
      $r .= "<td>R$ " . number_format($valor_total,2,",",".") . "</td>"; 
      $r .= "<td>R$ " . number_format($valor_pago,2,",",".") . "</td>"; 
      $r .= "<td>R$ " . number_format($divida,2,",",".") . "</td>"; 
      $r .= "<td><a href='/detalhescompra.php?id=" . $c->id . "'> <img src=\"/img/lapis.svg\"></a></td></tr>";
    }
    $r .= "<td>Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td>R$ " . number_format($total,2,",",".") ."</td> <td></td></table>";
    echo $r;
        ?>
    </main>
    <?php
    include($_SERVER["DOCUMENT_ROOT"] . "/base/rodape.inq.php")
    ?>
</body>
</html>