<div class="source-link" style="float: right;">
<?php //echo $this->SourceCode->link(null, array('class' => 'btn btn-info')); ?>
</div>

<h2>Query strings and type safety</h2>
<p>
Query strings are usually strings, but - as some might not be aware of - can also be quite easily an array.
So not checking on the type and blindly using it in stringish operations can currently cause undesired results.
</p>

<?php
$data = <<<'TEXT'
$result = 'string' . $this->request->query('key'); // Dangerous without checking if set and a string
TEXT;
echo $this->Highlighter->highlight($data, ['lang' => 'php']);
?>

So with the current implementation of how query strings (and named params) work, one should always assert the correct type first:

<!--
<?php
echo time();
?>
!>

```php
dfsf<?php
echo time(); ?>
```

<?php
$data = <<<'TEXT'
$key = $this->request->query('key');
if (is_array($key)) { // Or: if (!is_scalar($key))
	throw new NotFoundException('Invalid query string'); // Simple 404
}
$result = 'string' . $this->request->query('key'); // Dangerous without checking if a stringish (=scalar) value
TEXT;
echo $this->Highlighter->highlight($data, ['lang' => 'php']);
?>
I opened a <a href="https://github.com/cakephp/cakephp/issues/2223">ticket regarding this issue</a>.

<h3>Demo/Example</h3>
<?php
	if (!empty($this->request->query)) {
		echo '<b>Result:</b>';
		echo pre(h($this->request->query));
	}
?>

<b>Let's test:</b>
<p>
<?php echo $this->Html->link('A simple string', ['action' => 'query_strings', '?' => ['key' => 'value']]); ?>

<?php echo $this->Html->link('A simple array', ['action' => 'query_strings', '?' => ['key' => ['v1', 'v2']]]); ?>
</p>
