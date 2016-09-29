<?php
  defined('_JEXEC') or die ();

class plgDroideformsCartSend extends JPlugin{


  public function __construct(&$subject, $config)
  {

    parent::__construct($subject, $config);

  }

  public function onDroideformsBeforePublisheLayout(&$module, &$layout, &$post, &$log)
  {
    JLoader::register('helperUno', JPATH_LIBRARIES . '/helperuno.php');
    $HelperItens = new helperUno();
    $produtos = $HelperItens->getListProduct();
    $concatProdutcs = "";
    if($produtos){
      $concatProdutcs = $this->getLayoutTableTop();
      foreach ($produtos as $k => $produto) {
        $concatProdutcs .= "<tr><td>{$produto['title']}</td><td style='text-align:center;'>{$produto['qtde']}</td></tr>";
      }
      $concatProdutcs .= $this->getLayoutTableBottom();
      $layout .= $concatProdutcs;
      $HelperItens->ClearCookie();
    }

  }

  public function getLayoutTableTop()
  {
    $html = "<table width='100%' border='1' >";
    $html .= "<thead><tr><th>Nome do produto</th><th>Quantidade</th></tr></thead>";
    $html .= "<tbody>";
    return $html;
  }

  public function getLayoutTableBottom()
  {
    $html = "</tbody>";
    $html .= "</table>";
    return $html;
  }

}


 ?>
