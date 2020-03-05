<?php
/**
 * @package            Joomla
 * @subpackage         Event Booking
 * @author             Tuan Pham Ngoc
 * @copyright          Copyright (C) 2010 - 2020 Ossolution Team
 * @license            GNU/GPL, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Layout variables
 * -----------------
 * @var   EventbookingTableEvent $item
 * @var   RADConfig              $config
 * @var   boolean                $showLocation
 * @var   stdClass               $location
 * @var   boolean                $isMultipleDate
 * @var   string                 $nullDate
 * @var   int                    $Itemid
 */

$bootstrapHelper = EventbookingHelperBootstrap::getInstance();

$dateFormat = $config->event_date_format;
$timeFormat = $config->event_time_format;
?>

<div class="card-body">

	<?php // Category
		$categories = [];
		foreach ($item->categories as $category)
		{
			$categories[] = $category->name;
		}
		// echo '<h4 class="h3">' . implode(',' , $categories) . '</h4>';
		echo '<h4 class="eb-event-category card-event-catid-' . $category->id . '">' . '<span>' . $category->name . '</span>' . '</h4>';
	?>

	<div class="eb-event-date-time">
		<?php // date
		if ($item->event_date == EB_TBC_DATE)
		{
			echo JText::_('EB_TBC');
		}
		else
		{
			echo '<span class="eb-date h1">' . JHtml::_('date', $item->event_date, 'd F Y', null) . '</span>';

			if (strpos($item->event_date, '00:00:00') === false)
			{
			?>
				<?php echo '<span class="eb-time h3">' . JHtml::_('date', $item->event_date, $timeFormat, null) ?>
			<?php
			}

			if ($item->event_end_date != $nullDate)
			{
				if (strpos($item->event_end_date, '00:00:00') === false)
				{
					$showTime = true;
				}
				else
				{
					$showTime = false;
				}

				$startDate =  JHtml::_('date', $item->event_date, 'Y-m-d', null);
				$endDate   = JHtml::_('date', $item->event_end_date, 'Y-m-d', null);

				if ($startDate == $endDate)
				{
					if ($showTime)
					{
					?>
						- <?php echo JHtml::_('date', $item->event_end_date, $timeFormat, null) . '</span>' ?>
					<?php
					}
				}
				else
				{
					echo " - " .JHtml::_('date', $item->event_end_date, $dateFormat, null);

					if ($showTime)
					{
					?>
						<span class="eb-time"><?php echo JHtml::_('date', $item->event_end_date, $timeFormat, null) ?></span>
					<?php
					}
				}
			}
		}
		?>
	</div>

	<div class="eb-event-price">
		<?php
		if ($item->individual_price > 0)
		{
			echo '<span class="h3">' . EventbookingHelper::formatCurrency($item->individual_price, $config, $item->currency_symbol) . '</span>';
		}
		else
		{
			echo '<span class="eb_free h3">' . JText::_('EB_FREE') . '</span>';
		}
		?>
	</div>

	<div class="eb-event-action">
		<?php if (!$item->can_register) : ?>
			<p>Session terminée</p>
		<?php else : ?>
			<a href="#eb-individual-registration-page" class="btn btn-lg">Inscrivez-vous</a>
		<?php endif ; ?>
	</div>
</div>
