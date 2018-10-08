<?php
  defined('_JEXEC') or die ();

class plgDroideformsCartSend extends JPlugin{


  public function __construct(&$subject, $config)
  {

    parent::__construct($subject, $config);

  }

  public function getListProduct()
{
  $app = JFactory::getApplication();
  $input = $app->input->cookie;
  $droidecart = $input->get('droide-cart','{}', $filter = 'string');
  $arraycart = json_decode($droidecart,true);

  $items_id = array_keys($arraycart);
  $results = [];
  if($items_id){
    $items_id = implode(',',$items_id);
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select(array('id', 'title'));
    $query->from('#__k2_items');
    $query->where('id in('.$items_id.')');
    $db->setQuery($query);
     $getBD = $db->loadObjectList();

     foreach ($getBD as $k => $k2item) {
       $results[] = [
         'id'=>$k2item->id,
         'title'=>$k2item->title,
         'qtde'=>$arraycart[$k2item->id],
       ];
     }

  }

  return $results;
}

public function ClearCookie()
{
  $app = JFactory::getApplication();
  $cookies = $app->input->cookie;
  $cookies->set('droide-cart', null, time() - 1);
}

  public function onDroideformsBeforePublisheLayout(&$module, &$layout, &$post, &$log)
  {
    $produtos = $this->getListProduct();
    $concatProducts = "";
    if($produtos){
      $concatProducts = $this->getLayoutTableTop();
      foreach ($produtos as $k => $produto) {
        $concatProducts .= "<tr><td>{$produto['title']}</td><td style='text-align:center;'>{$produto['qtde']}</td></tr>";
      }
      $concatProducts .= $this->getLayoutTableBottom();
      $layout .= $concatProducts;
      $this->ClearCookie();
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
