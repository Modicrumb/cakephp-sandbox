<h2>Hashid Examples</h2>
<p>
<a href="https://github.com/dereuromark/cakephp-hashid" target="_blank">[Source]</a>
</p>

<p>
Basically, the plugin uses short alphanumeric ids instead of the actual numeric ones.
</p>

<?php
$this->loadHelper('Hashid.Hashid');
$i = 1;
?>
<table class="table" style="width:400px">
	<tr>
		<th>Auto increment ID (Primary key)</th><th>Hashid</th>
	</tr>
<?php while ($i < PHP_INT_MAX / 100) { ?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $this->Hashid->encodeId($i); ?></td>
	</tr>
<?php
	$i = $i * 100;
}
?>
	<tr><td><?php echo PHP_INT_MAX; ?> (PHP_INT_MAX)</td><td><?php echo $this->Hashid->encodeId(PHP_INT_MAX); ?></td></tr>
</table>

<p>
	Of course the actual hashids are always different and unique per system, based on the salt that was provided.
</p>

<h3>Hashid plugin examples</h3>
<ul>
	<li><?php echo $this->Html->link('Show hashids in action', ['action' => 'pagination'])?></li>
</ul>
