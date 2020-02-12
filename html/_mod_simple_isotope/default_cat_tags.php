<?php
/**
* Simple isotope module  - Joomla Module
* Version			: 1.2.2
* Package			: Joomla 3.x.x
* copyright 		: Copyright (C) 2017 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* From              : isotope.metafizzy.co
* Updated on        : February, 2018
* 1.2.2				: Perso : suppress null fields {notnull} tag
*/

defined('_JEXEC') or die;
$uri = JUri::getInstance();
$user = JFactory::getUser();
$defaultdisplay = $params->get('defaultdisplay', 'date_desc');
$displaysortinfo = $params->get('displaysortinfo', 'show');
$article_cat_tag = $params->get('cat_or_tag',$iso_entree == "webLinks"?'cat':'tags');
$displayfilter =  $params->get('displayfilter','button');
$titlelink =  $params->get('titlelink','true');
if ($article_cat_tag =="cat") {
    $displayfiltercat = $params->get('displayfiltercat',$displayfilter);
} else {
    $displayfiltercat = $params->get('displayfiltercattags',$displayfilter);
}
$displaysort =  $params->get('displaysort','show');
$displaybootstrap = $params->get('bootstrapbutton','false');
$displaysearch=$params->get('displaysearch','false');
$imgmaxwidth = $params->get('introimg_maxwidth','0');
$imgmaxheight = $params->get('introimg_maxheight','0');
$div_bootstrap = "";
$button_bootstrap = "isotope_button";
$col_bootstrap_sort = "";
$col_bootstrap_filter = "";
$div_bootstrap = "row";
if ($displaybootstrap == 'true') {
	$button_bootstrap = "btn btn-sm btn-outline-black ";
}
if ($iso_entree == "webLinks") {
	$col_bootstrap_sort = "col-md-6 col-sm-6 col-xs-6";
	$col_bootstrap_filter = "col-md-6 col-sm-6 col-xs-6";
} else {
	$col_bootstrap_sort = "col-md-5 col-sm-5 col-xs-5";
	$col_bootstrap_filter = "col-md-7 col-sm-5 col-xs-5";
}
if ($article_cat_tag == 'cattags') {$col_bootstrap_filter = "col-md-6 col-sm-5 col-xs-5";}
if (($displaysort == "hide") && ($displaysearch == "false") && ($article_cat_tag != 'cattags')) {
	$col_bootstrap_filter = "col-md-12 col-sm-12 col-xs-12";
}
if ($displayfilter == "hide") {
    if ($displaysearch == "true") {
	    $col_bootstrap_sort = "col-md-6 col-sm-6 col-xs-6";
	} else {
	    $col_bootstrap_sort = "col-md-12 col-sm-6 col-xs-12";
    }
}
echo '<style type="text/css">';
if (($iso_layout == "masonry") || ($iso_layout == "fitRows") || ($iso_layout == "packery")) {
	echo '#isotope-div-'.$module->id.' .isotope_item {width: '.((100 / $iso_nbcol)-2).'% }';
} else if ($iso_layout == "vertical") {
	echo '#isotope-div-'.$module->id.' .isotope_item {width: 100%; }';
}
echo '#isotope-div-'.$module->id.' .isotope_item {background:'.$params->get("backgroundcolor","#eee").';}';
if ($imgmaxwidth > 0) {
    echo '#isotope-div-'.$module->id.' .isotope_item img {max-width: '.$imgmaxwidth.'%;}';
}
if ($imgmaxheight > 0) {
    echo '#isotope-div-'.$module->id.' .isotope_item img {max-height: '.$imgmaxheight.'px;}';
}
echo '</style>';
$libreverse=JText::_('SSISO_LIBREVERSE');
$liball = JText::_('SSISO_LIBALL');
$libdate = JText::_('SSISO_LIBDATE');
$libcategory = JText::_('SSISO_LIBCAT');
$libvisit= JText::_('SSISO_LIBVISIT');
$librating= JText::_('SSISO_LIBRATING');
$libalpha=JText::_('SSISO_LIBALPHA');
$libcreated=JText::_('SSISO_LIBCREATED');
$libupdated=JText::_('SSISO_LIBUPDATED');
$libfilter=JText::_('SSISO_LIBFILTER');
$libdateformat = JText::_('SSISO_DATEFORMAT'); // format d'affichage des dates au format php d/m/Y H:i  = format fran�ais avec heure/minutes
$libsearch = JText::_('SSISO_LIBSEARCH');
?>
<div id="isotope-div-<?php echo $module->id;?>">
<div class="isotope-div <?php echo $div_bootstrap; ?>" >
<?php if (!($displaysort == "hide")) {
		if ($displaysearch == "true") {?>
<div class="<?php echo $col_bootstrap_sort; ?>">
<div class="isotope_button-group sort-by-button-group">
		<?php } else { ?>
<div class="<?php echo $col_bootstrap_sort; ?> isotope_button-group sort-by-button-group">
		<?php }
$checked = " is-checked ";
if ($params->get('btndate','true') == "true") {
	$sens = "-";
	$sens = $defaultdisplay=="date_desc"? "+": $sens;
	echo '<button class="'.$button_bootstrap.$checked.' is-checked iso_button_date" data-sort-value="date,title,category,click" data-sens="'.$sens.'" title="'.$libreverse.'">'.$libdate.'</button>';
	$checked = "";
}
if ($params->get('btncat','true') == "true") {
	$sens = "-";
	$sens = $defaultdisplay=="cat_desc"? "+": $sens;
	echo '<button class="'.$button_bootstrap.$checked.' iso_button_cat" data-sort-value="category,title,date,click" data-sens="'.$sens.'" title="'.$libreverse.'">'.$libcategory.'</button>';
	$checked = "";
}
if ($params->get('btnalpha','true') == "true") {
	$sens = "-";
	$sens = $defaultdisplay=="alpha_desc"? "+": $sens;
	echo '<button class="'.$button_bootstrap.$checked.' iso_button_alpha" data-sort-value="title,category,date,click" data-sens="'.$sens.'" title="'.$libreverse.'">'.$libalpha.'</button>';
	$checked = "";
}
if ($params->get('btnvisit','true') == "true") {
	$sens = "-";
	$sens = $defaultdisplay=="click_desc"? "+": $sens;
	echo '<button class="'.$button_bootstrap.$checked.' iso_button_click" data-sort-value="click,category,title,date" data-sens="'.$sens.'" title="'.$libreverse.'">'.$libvisit.'</button>';
	$checked = "";
}
if ($iso_entree != "webLinks") {
	if ((JPluginHelper::isEnabled('content', 'vote')) && ($params->get('btnrating','true') == "true")) {
		$sens = "-";
		$sens = $defaultdisplay=="rating_desc"? "+": $sens;
		echo '<button class="'.$button_bootstrap.$checked.' iso_button_click" data-sort-value="rating,category,title,date" data-sens="'.$sens.'" title="'.$libreverse.'">'.$librating.'</button>';
		$checked = "";
	}
}
  ?>
<?php if ($displaysearch == "true") {
	if (!($displayfilter == "hide")) {?>
		</div>
		<div class="iso_search <?php echo $col_bootstrap_sort; ?>" >
		<input type="text" class="quicksearch" placeholder="<?php echo $libsearch;?>" />
		</div>
	<?php } else { // no filter button ?>
	    </div>
		<div class="iso_search <?php echo $col_bootstrap_sort; ?>"   >
		<input type="text" class="quicksearch" placeholder="<?php echo $libsearch;?>" />
	<?php }
	}?>
</div>
<?php }
 if (($displaysort == "hide") && ($displaysearch == "true")) { ?>
<div class="iso_search <?php echo $col_bootstrap_sort; ?>" style="float:left"><input type="text" class="quicksearch" placeholder="<?php echo $libsearch;?>" /></div>
 <?php }
 if ((($article_cat_tag == "tags") && ($displayfilter != "hide")) || (($article_cat_tag =="cat") && ($displayfiltercat != "hide"))
	 || (($article_cat_tag == "cattags") && (($displayfilter != "hide") || ($displayfiltercat != "hide")))) {
	$filters = array();
	if ( ($article_cat_tag  == "tags") ||  ($article_cat_tag  == "cattags") ) {
		if (count($tags_list) > 0) { // on a d�fini une liste de tags
			foreach ($tags_list as $key) {
			$filters['tags'][]= ModIsotopeHelper::getTagTitle($key);
			}
		}
	}
	if (($article_cat_tag  == "cat") ||  ($article_cat_tag  == "cattags")) {
	    if (is_null($categories) ) {
           $keys = array_keys($cats_lib);
           $filters['cat'] = $keys;
	    } else {
		  $filters['cat']= $categories;
	    }
	}
	if (($article_cat_tag  == "cat") || ($article_cat_tag  == "cattags")) {
		// categories sort
		$sortFilter = array();
		// 1.1.6 : category alias parameter
		if ($params->get('catfilteralias','false') == 'true') { // sort category aliases
			foreach ($cats_alias as $key => $filter) {
				$sortFilter[$key] = $cats_alias[$key];
			}
		} else { // sort category names
			foreach ($filters['cat'] as $filter) {
				$sortFilter[$filter] = $cats_lib[$filter];
			}
		}
	    asort($sortFilter,  SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL ); // alphabatic order
	    if  (($displayfiltercat == "button")  || ($displayfiltercat == "multi") || ($displayfiltercat == "multiex")) {
    	    echo '<div class="'.$col_bootstrap_filter.'  isotope_button-group filter-button-group-cat" data-filter-group="cat">';
		    echo '<button class="'.$button_bootstrap.'  iso_button_cat_tout is-checked" data-sort-value="0" />'.$liball.'</button>';
		    foreach ($sortFilter as $key => $filter) {
		        $aff = $cats_lib[$key];
		        $aff_alias = $cats_alias[$key];
				if (!is_null($aff)) {
					echo '<button class="'.$button_bootstrap.'  iso_button_cat_'.$aff_alias.'" data-sort-value="'.$aff_alias.'" />'.$aff.'</button>';
				}
			}
			echo '</div>';
		} else {
		    echo '<div class="'.$col_bootstrap_filter.'  isotope_button-group filter-button-group-cat" data-filter-group="cat">';
		    echo '<p class="hidden-phone" >'.$libfilter.' : </p><select class="isotope_select" data-filter-group="cat">';
		    echo '<option>'.$liball.'</option>';
		    foreach ($sortFilter as $key => $filter) {
		        $aff = $cats_lib[$key];
		        $aff_alias = $cats_alias[$key];
		        if (!is_null($aff)) {
		            echo '<option value="'.$aff_alias.'">'.$aff.'</option>';
		        }
		    }
		    echo '</select>';
		    echo '</div>';
		}
	}
	if (( $article_cat_tag  == "tags") || ($article_cat_tag  == "cattags")) {
	    // tri des tags
		$sortFilter = array();
		if (count($tags_list) > 0) {
			foreach ($filters['tags'] as $filter) {
				$sortFilter[] = $filter[0]->tag;
				$alias[$filter[0]->tag] = $filter[0]->alias;
			}
		} else { // 1.1.9 : empty tags list: take all tags found in articles
			foreach ($tags as $key=>$value) {
				$sortFilter[] = $value;
				$alias[$value] = $tags_alias[$value];
			}
		}
	    asort($sortFilter,  SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL ); // alphabetic order
	    if (($displayfilter == "button") || ($displayfilter == "multi") || ($displayfilter == "multiex") ) {
	         echo '<div class="'.$col_bootstrap_filter.'  isotope_button-group filter-button-group-tags" data-filter-group="tags">';
			echo '<button class="'.$button_bootstrap.'  iso_button_cat_tout is-checked" data-sort-value="0" />'.$liball.'</button>';
			foreach ($sortFilter as $filter) {
			    $aff = $filter;
			    $aff_alias = $alias[$filter];
				if (!is_null($aff)) {
					echo '<button class="'.$button_bootstrap.'  iso_button_tags_'.$aff_alias.'" data-sort-value="'.$aff_alias.'" />'.$aff.'</button>';
				}
			}
			echo '</div>';
		}   else  {	// affichage Liste
			echo '<div class="'.$col_bootstrap_filter.'  isotope_button-group filter-button-group-tags" data-filter-group="tags">';
			echo '<p class="hidden-phone" >'.$libfilter.' : </p><select class="isotope_select" data-filter-group="cat">';
			echo '<option>'.$liball.'</option>';
			foreach ($sortFilter as $filter) {
			    $aff = $filter;
			    $aff_alias = $alias[$filter];
				if (!is_null($aff)) {
					echo '<option value="'.$aff_alias.'">'.$aff.'</option>';
				}
			}
			echo '</select>';
			echo '</div>';
		}
	}
?>
<?php } ?>
</div>
<div class="isotope_grid">
<?php
foreach ($list as $key=>$category) {
	foreach ($category as $item) {
		$tag_display = "";
		if (($article_cat_tag  == "tags") || ($article_cat_tag  == "cattags")) { // filtre tag
			foreach ($article_tags[$item->id] as $tag) {
				$tag_display = $tag_display." ".$tags_alias[$tag->tag];
			};
		} else { // filtre cat�gories
			$tag_display =  $item->category_alias;
		}
		$field_cust = array();
		if (isset($article_fields) and array_key_exists($item->id,$article_fields)) { //1.1.10 : merci Lomart
			foreach ($article_fields[$item->id] as $key_f=>$tag_f) {
				$field_cust['{'.$key_f.'}'] = $tag_f; // champ personnalis� affichable
			};
		}
		$ladate = $iso_entree == "webLinks"? $item->created : $item->displayDate;
		$data_cat = $iso_entree == "webLinks"? $cats_alias[$item->catid] : $item->category_alias;
		$click = $item->hits;
		echo '<div class="isotope_item iso_cat_'.$key.' '.$tag_display.'" data-title="'.$item->title.'" data-category="'.$data_cat.'" data-date="'.$ladate.'" data-click="'.$click.'" data-rating="'.$item->rating.'">';
		if ($iso_entree == "webLinks") {
			$canEdit = $user->authorise('core.edit', 'com_weblinks.category.' . $key);
			if ($canEdit) {
				echo '<span class="list-edit pull-left width-50">';
			    echo '<a href="index.php?option=com_weblinks&task=weblink.edit&w_id='.$item->id.'&return='.base64_encode($uri).'">';
				echo '<img src="media/system/images/edit.png" alt="modifier" style="max-width:100%"></a>';
				echo '</span>';
			}
			if ($titlelink == "true") {
				$title = '<p><a href="'.$item->link.'" target="_blank" rel="noopener noreferrer">'.$item->title.'</a>&nbsp;';
			} else {
				$title = '<p>'.$item->title.'&nbsp;';
			}

			$perso = $params->get('perso');
			$arr_css= array("{title}"=>$title, "{cat}"=>$cats_lib[$item->catid],"{date}"=>$libcreated.JHtml::_('date', $item->created, $libdateformat), "{visit}" =>$item->hits, "{intro}" => $item->description);
			foreach ($arr_css as $key => $val) {
				$perso = str_replace($key,$val,$perso);
			}
			echo $perso;

		} else {
		    // echo'<p>';
			$canEdit = $user->authorise('core.edit', 'com_content.article.'.$item->id);
			if ($canEdit) {
				echo '<span class="edit-icon">';
				echo '<a href="index.php?task=article.edit&a_id='.$item->id.'&return='.base64_encode($uri).'">';
				echo '<img src="media/system/images/edit.png" alt="modifier" style="max-width:100%"></a>';
				echo '</span>';
			}
			if ($titlelink == "true") {
				$title = '<a href="'.$item->link.'">'.$item->title.'</a>';
			} else {
				$title = $item->title;
			}
			$rating = '';
			for ($i = 1; $i <= $item->rating; $i++) {
			    $rating .= '<img src='.$modulefield.'images/icon.png />';
			}
			// 1.2.2 : plugin phocaount => new parameter {count}
			$phocacount = ModIsotopeHelper::getArticlePhocaCount($item->fulltext);
			$choixdate = $params->get('choixdate', 'modified');
			$libdate = $choixdate == "modified" ? $libupdated : $libcreated;
			$perso = $params->get('perso');
			$perso = ModIsotopeHelper::checkNullFields($perso,$item,$phocacount); // suppress null field if required
			$arr_css= array("{title}"=>$title, "{cat}"=>$cats_lib[$item->catid],"{date}"=>$libdate.JHtml::_('date', $item->displayDate, $libdateformat), "{visit}" =>$item->hits, "{intro}" => $item->displayIntrotext,"{stars}"=>$rating,"{rating}"=>$item->rating,"{ratingcnt}"=>$item->rating_count,"{count}"=>$phocacount);
			foreach ($arr_css as $key_c => $val_c) {
				$perso = str_replace($key_c,$val_c,$perso);
			}
			foreach ($field_cust as $key_f => $val_f) { // affichage du contenu des champs personnalis�es
				$perso = str_replace($key_f,$val_f,$perso);
			}
			echo $perso;
			if ($params->get('readmore','false') =='true') {
				echo '<p class="isotope-readmore">';
				echo '<a class="isotope-readmore-title" href="'.$item->link.'">';
				echo JText::_('SSISO_READMORE');
				echo '</a>';
        // echo '</p>';
			}
		}
		echo '</div>';
	}
}
?>
</div>
</div>
<script>
jQuery("#isotope-div-<?php echo $module->id;?>").ready(function() {
var me = "#isotope-div-<?php echo $module->id;?> ";
var qsRegex;
var parent = 'cat'; // pr�voir la bonne valeur
var filters = {};
filters['cat'] = ['*'];
filters['tags'] = ['*'];

var $grid = jQuery(me + '.isotope_grid').imagesLoaded(
   function() {
	$grid.isotope({
     itemSelector: me + '.isotope_item',
     percentPosition: true,
  <?php
	echo "layoutMode:'".$iso_layout."',";
	?>
  getSortData: {
    title: '[data-title]',
    category: '[data-category]',
	date: '[data-date]',
	click: '[data-click] parseInt',
	rating: '[data-rating] parseInt'
  },
<?php
  if ($defaultdisplay == "date_asc")  echo "sortBy: [ 'date','category','title','click'], sortAscending: true";
  if ($defaultdisplay == "date_desc")  echo "sortBy: [ 'date','category','title','click'], sortAscending: false";
  if ($defaultdisplay == "cat_asc")   echo "sortBy: [ 'category','title','date','click'], sortAscending: true";
  if ($defaultdisplay == "cat_desc")   echo "sortBy: [ 'category','title','date','click'], sortAscending: false";
  if ($defaultdisplay == "alpha_asc")   echo "sortBy: [ 'title','category','date','click'], sortAscending: true";
  if ($defaultdisplay == "alpha_desc")   echo "sortBy: [ 'title','category','date','click'], sortAscending: false";
  if ($defaultdisplay == "click_asc")   echo "sortBy: [ 'click','category','title','date'], sortAscending: true";
  if ($defaultdisplay == "click_desc")   echo "sortBy: [ 'click','category','title','date'], sortAscending: false";
  if ($defaultdisplay == "rating_asc")   echo "sortBy: [ 'rating','category','title','date'], sortAscending: true";
  if ($defaultdisplay == "rating_desc")   echo "sortBy: [ 'rating','category','title','date'], sortAscending: false";
?>
	,
  filter: function() {
    var $this = jQuery(this);
    var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
	var	lacat = $this.attr('data-category');
	var laclasse = $this.attr('class');
	var lescles = laclasse.split(" ");
	var buttonResult = false;
	if ((filters['cat'].indexOf('*') != -1) && (filters['tags'].indexOf('*') != -1)) { return searchResult && true};
	count = 0;
	if (filters['cat'].indexOf('*') == -1) { // on a demand� une classe
		if (filters['cat'].indexOf(lacat) == -1)  {
			return false; // n'appartient pas � la bonne classe: on ignore
		} else { count = 1; } // on a trouv� la cat�gorie
	}
	if (filters['tags'].indexOf('*') != -1) { // tous les tags
		return searchResult && true;
	}
	for (var i in lescles) {
			if  (filters['tags'].indexOf(lescles[i]) != -1)
			{
				buttonResult = true;
				count += 1;
			}
		}
<?php
 if (  ( ($article_cat_tag == "tags") && ($displayfilter == "multiex"))
	|| ( ($article_cat_tag  == "cattags") && ($displayfilter == "multiex"))
    || ( ($article_cat_tag == "cat") && ($displayfiltercat == "multiex"))
	|| ( ($article_cat_tag  == "cattags") && ($displayfiltercat == "multiex")))
 { ?>
	lgth = filters['cat'].length + filters['tags'].length;
	if ((filters['tags'].indexOf('*') != -1) || (filters['cat'].indexOf('*') != -1)) {lgth = lgth - 1;}
	return searchResult && (count == lgth);
 <?php } else { ?>
	 return searchResult && buttonResult;
 <?php } ?>
  }
   });
});
// 1.2 : CG isotope switcher
jQuery(me + '.isotope-div').on("refresh", function(){
 	  $grid.isotope();
  });
// 1.2 : fin des modifications


// bind sort button click
jQuery(me+'.sort-by-button-group').on( 'click', 'button', function() {
 var sortValue = jQuery(this).attr('data-sort-value'),
 sens = jQuery(this).attr('data-sens');
  sortValue = sortValue.split(',');
  if (sens == "+") {
	jQuery(this).attr("data-sens","-");
    asc = true;
	} else {
  	jQuery(this).attr("data-sens","+");
	asc = false;
  }
  $grid.isotope({
	sortBy: sortValue,
	sortAscending: asc,
  });
});
jQuery(me+'.sort-by-button-group').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    $buttonGroup.find('.is-checked').removeClass('is-checked');
    jQuery( this ).addClass('is-checked');
  });
});
// use value of search field to filter
var $quicksearch = jQuery(me+'.quicksearch').keyup( debounce( function() {
  qsRegex = new RegExp( $quicksearch.val(), 'gi' );
  $grid.isotope();
}) );
// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    timeout = setTimeout( delayed, threshold || 100 );
  }
  }
<?php if  ($displayfilter == "list") { ?>
jQuery(me+'.filter-button-group-tags').on( 'change', function() {
  parent = jQuery(this).attr('data-filter-group');
  var sortValue = jQuery(this).find(":selected").val();
  if (sortValue == '<?php echo $liball;?>')   {
	filters[parent] = ['*'];
  } else
  {
   filters[parent] = [sortValue];
  }
  $grid.isotope();
});
<?php }
	if  ($displayfiltercat == "list") { ?>
jQuery(me+'.filter-button-group-cat').on( 'change', function() {
  parent = jQuery(this).attr('data-filter-group');
  var sortValue = jQuery(this).find(":selected").val();
  if (sortValue == '<?php echo $liball;?>')   {
	filters[parent] = ['*'];
  } else
  {
   filters[parent] = [sortValue];
  }
  $grid.isotope();
});
<?php }
	if (($displayfiltercat == "multi") || ($displayfiltercat == "multiex")) {
?>
jQuery(me+'.filter-button-group-cat').on( 'click', 'button', function() {
  parent = jQuery(this).parent().attr('data-filter-group');
  sortValue = jQuery(this).attr('data-sort-value');
  jQuery(this).toggleClass('is-checked');
  var isChecked = jQuery(this).hasClass('is-checked');
  if (sortValue == 0) { // tout
	filters[parent] = ['*'];
  } else {
	removeFilter(parent,'*');
    if ( isChecked ) {
		addFilter( parent,sortValue );
	} else {
		removeFilter( parent, sortValue );
	}
  }
  $grid.isotope();

  });
  jQuery(me+'.filter-button-group-cat').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    if (jQuery(this).attr('data-sort-value') == 0) { // on a cliqu� sur tout => on remet le reste � blanc
		jQuery(this).parent().find('.is-checked').removeClass('is-checked');
		jQuery( this ).addClass('is-checked');
	} else { // on a cliqu� sur un autre bouton : uncheck le bouton tout
	    jQuery(this).parent().find('[data-sort-value="0"]').removeClass('is-checked');
	}
  });
});
<?php } ?>
<?php
	if (($displayfilter == "multi") || ($displayfilter == "multiex")) { ?>
jQuery(me+'.filter-button-group-tags').on( 'click', 'button', function() {
  parent = jQuery(this).parent().attr('data-filter-group');
   sortValue = jQuery(this).attr('data-sort-value');
  jQuery(this).toggleClass('is-checked');
  var isChecked = jQuery(this).hasClass('is-checked');
  if (sortValue == 0) { // tout
	filters[parent] = ['*'];
  } else {
	removeFilter(parent,'*');
    if ( isChecked ) {
		addFilter( parent,sortValue );
	} else {
		removeFilter( parent, sortValue );
	}
  }
  $grid.isotope();

  });
  jQuery(me+'.filter-button-group-tags').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    if (jQuery(this).attr('data-sort-value') == 0) { // on a cliqu� sur tout => on remet le reste � blanc
		jQuery(this).parent().find('.is-checked').removeClass('is-checked');
		jQuery( this ).addClass('is-checked');
	} else { // on a cliqu� sur un autre bouton : uncheck le bouton tout
	    jQuery(this).parent().find('[data-sort-value="0"]').removeClass('is-checked');
	}
  });
});
<?php } ?>
<?php
if ($displayfiltercat == "button"){?>
jQuery(me+'.filter-button-group-cat').on( 'click', 'button', function() {
  parent = jQuery(this).parent().attr('data-filter-group');
  var sortValue = jQuery(this).attr('data-sort-value');
  if (sortValue == 0) {
   filters[parent] = ['*'];
  } else
  {
   filters[parent]= [sortValue];
   }
   $grid.isotope();
});
jQuery(me+'.filter-button-group-cat').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  parent = jQuery(this).parent().attr('data-filter-group');
  $buttonGroup.on( 'click', 'button', function() {
    jQuery(this).parent().find('.is-checked').removeClass('is-checked');
    jQuery( this ).addClass('is-checked');
  });
});
<?php } ?>
<?php
if ($displayfilter == "button") { ?>
jQuery(me+'.filter-button-group-tags').on( 'click', 'button', function() {
  parent = jQuery(this).parent().attr('data-filter-group');
  var sortValue = jQuery(this).attr('data-sort-value');
  if (sortValue == 0) {
   filters[parent] = ['*'];
  } else
  {
   filters[parent]= [sortValue];
   }
   $grid.isotope();
});
jQuery(me+'.filter-button-group-tags').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  parent = jQuery(this).parent().attr('data-filter-group');
  $buttonGroup.on( 'click', 'button', function() {
    jQuery(this).parent().find('.is-checked').removeClass('is-checked');
    jQuery( this ).addClass('is-checked');
  });
});
<?php } ?>
function addFilter( parent, filter ) {
  if ( filters[parent].indexOf( filter ) == -1 ) {
    filters[parent].push( filter );
  }
}

function removeFilter( parent, filter ) {
  var index = filters[parent].indexOf( filter);

  if ( index != -1 ) {
    filters[parent].splice( index, 1 );
  }
}
});
</script>
