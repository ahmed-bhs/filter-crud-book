<?php
require 'dbconfig.php';
$nbMembreprpage = 15; //le nombre de membres par page
$sear = $sql->q('SELECT COUNT(*) AS nb_membre FROM user');
$recup = $sear->fetch_array();
$totalMembre = $recup['nb_membre'];
$nbDePages  = ceil($totalMembre / $nbMembreprpage);
 
if (isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])) {
                                                                          $page = $_GET['id'];
                                                                  }
                                                             else {
                                                                           $_GET['id'] = 1;
                                                                           $page = 1;
                                                                   }
  
 // on lance la requete qui ira chercher les membres par exemple...
                         $premierMembre = ($page - 1) * $nbMembreprpage;
                         $selec = $sql->query('SELECT * FROM ?? ORDER BY ?? DESC...  LIMIT ' . $premierMembre . ', ' . $nbMembreprpage.'');
// regarde si il a quelque chose de trouver...
if ($selec->num_rows == 0) {
                                  echo 'Aucun membre trouv&eacute;e';
                           }
                      else {
// oui il y a quelque chose alors on lance un tableau et un while pour recuperer les infos..
                                  echo '<table width="100%" border="1" class="tableau"><tr><th width="1%">Position</td></tr>';
                                  $i = 1;
  while($donnee = $selec->fetch_array()) {
                                            // on calcule quel est sa position..
                                            $nbligne = $page * $nbMembreprpage + $i++ - 15;
                                            echo '<tr><td align="center">',$nbligne,'</td></tr>';                  
                                          }
                 
                                  echo'</table>';
 
// lancement checkup des pages precedents si nous sommes pas a la premiere page..
if ($page != 1){
                                  $pageprece = ($_GET['id']-1);
                                  $pageprece1 = ($_GET['id']-2);
                                  $pageprece2 = ($_GET['id']-3);
                                  $pageprece3 = ($_GET['id']-4);
                                  $pageprece4 = ($_GET['id']-5);
                                  $pageprece5 = 1;
     
                    echo'<a style="text-decoration:none;" href="?id=' .$pageprece5. '"><</a>';
 
if ($pageprece4 >= 1){
                       echo'<a style="text-decoration:none;" href="?id=' .$pageprece4. '">-' .$pageprece4. '</a>';
}
if ($pageprece3 >= 1){
                       echo'<a style="text-decoration:none;" href="?id=' .$pageprece3. '">-' .$pageprece3. '</a>';
}
if ($pageprece2 >= 1){
                       echo'<a style="text-decoration:none;" href="?id=' .$pageprece2. '">-' .$pageprece2. '</a>';
}
if ($pageprece1 >= 1){
                       echo'<a style="text-decoration:none;" href="?id=' .$pageprece1. '">-' .$pageprece1. '</a>';
}
if ($pageprece >= 1){
                       echo'<a style="text-decoration:none;" href="?id=' .$pageprece. '">-' .$pageprece. '</a>';
}
               } else { }
// lancement du checkup des pages suivante..
                       echo '&nbsp;&nbsp;';
                       $pagesuiv = ($_GET['id']+1);
                       $pagesuiv1 = ($_GET['id']+2);
                       $pagesuiv2 = ($_GET['id']+3);
                       $pagesuiv3 = ($_GET['id']+4);
                       $pagesuiv4 = ($_GET['id']+5);
                       $pagesuiv5 = $nbDePages;
 
if ($pagesuiv <= $nbDePages){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv . '">' . $pagesuiv . '</a>';
}
if ($pagesuiv1 <= $nbDePages){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv1 . '">-' . $pagesuiv1 . '</a>';
}
if ($pagesuiv2 <= $nbDePages){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv2 . '">-' . $pagesuiv2 . '</a>';
}
if ($pagesuiv3 <= $nbDePages){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv3 . '">-' . $pagesuiv3 . '</a>';
}
if ($pagesuiv4 <= $nbDePages){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv4 . '">-' . $pagesuiv4 . '</a>';
}
if ($page != $nbDePages && $nbDePages > 1){
                               echo '<a style="text-decoration:none;" href="?id=' . $pagesuiv5 . '">-></a>';
}
                            }
$selec->free_result();
 
?>