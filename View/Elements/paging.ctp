<?php
/**
 * Common pagination widget
 *
 */
	$pagingOptions = array('tag' => 'li', 'escape' => false);
	$paginationEnabled = $this->Paginator->hasPrev() || $this->Paginator->hasNext();
?>
<?php if ($paginationEnabled): ?>
<ul class="pager">
<?php
	echo $this->Paginator->prev(
		'&larr;',
		$pagingOptions + array('class' => 'previous'),
		null,
		$pagingOptions + array('class' => 'previous disabled')
	);
	echo $this->Paginator->numbers($pagingOptions + array('separator' => ''));
	echo $this->Paginator->next(
		'&rarr;',
		$pagingOptions,
		null,
		$pagingOptions + array('class' => 'next disabled')
	);
?>
</ul>
<?php endif; ?>