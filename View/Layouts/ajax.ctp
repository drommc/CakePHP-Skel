<?=
	$this->fetch('content') .
	$this->fetch('script') .
	$this->Js->writeBuffer()
?>