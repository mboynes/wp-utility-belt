<div id="printf">
	<div class="view-container span6">
		<form method="post" data-response="printf_response" class="form-vertical">
			<input type="hidden" name="action" value="printf" />
			<div class="control-group">
				<label class="control-label" for="printf_format">Format</label>
				<div class="controls">
					<input type="text" name="printf_format" value="The %s ate %d %s!" id="printf_format" class="span3" />
				</div>
				<a href="#printfModal" role="button" class="btn" data-toggle="modal">Reference</a>
			</div>

			<div class="control-group">
				<label class="control-label" for="printf_arguments">Arguments (one per line</label>
				<div class="controls">
					<textarea name="printf_arguments" id="printf_arguments" rows="4" class="span3"></textarea>
				</div>
			</div>

			<div class="form-actions">
				<input name="printf" value="Process" type="submit" class="btn" />
			</div>
		</form>
	</div>

	<div id="printf_response" class="view-container span6"></div>
</div>

<div id="printfModal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>printf/sprintf Quick Reference</h3>
	</div>
	<div class="modal-body">

		<h4>Regex Representation</h4>
		<pre>/%(\d+\$)?\+?(0|'.)?-?\d*(\.\d+)?[%bcdeEufFgGosxX]/</pre>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="2">
						Breakdown<br />
						%[argument][sign][padding][alignment][width][precision][type]
					</th>
				</tr>
				<tr>
					<th>Specifier</th>
					<th>Format</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>argument</td>
					<td>(\d+\$)?</td>
					<td>For argument ordering, e.g. %2$s</td>
				</tr>
				<tr>
					<td>sign</td>
					<td>\+?</td>
					<td>Include + or - for numbers</td>
				</tr>
				<tr>
					<td>padding</td>
					<td>(0|'.)?</td>
					<td>Character padding; can be 0 or '[any character]</td>
				</tr>
				<tr>
					<td>alignment</td>
					<td>-?</td>
					<td>Padding occurs on the left; add a - to pad on the right</td>
				</tr>
				<tr>
					<td>width</td>
					<td>\d*</td>
					<td>Number of characters to pad to</td>
				</tr>
				<tr>
					<td>precision</td>
					<td>(\.\d+)?</td>
					<td>Number of decimal places for floats</td>
				</tr>
				<tr>
					<td>type</td>
					<td>[%bcdeEufFgGosxX]</td>
					<td>See below</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="2">Types</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>%</td>
					<td>a literal percent character. No argument is required.</td>
				</tr>
				<tr>
					<td>b</td>
					<td>the argument is treated as an integer, and presented as a binary number.</td>
				</tr>
				<tr>
					<td>c</td>
					<td>the argument is treated as an integer, and presented as the character with that ASCII value.</td>
				</tr>
				<tr>
					<td>d</td>
					<td>the argument is treated as an integer, and presented as a (signed) decimal number.</td>
				</tr>
				<tr>
					<td>e</td>
					<td>the argument is treated as scientific notation (e.g. 1.2e+2). The precision specifier stands for the number of digits after the decimal point since PHP 5.2.1. In earlier versions, it was taken as number of significant digits (one less).</td>
				</tr>
				<tr>
					<td>E</td>
					<td>like %e but uses uppercase letter (e.g. 1.2E+2).</td>
				</tr>
				<tr>
					<td>u</td>
					<td>the argument is treated as an integer, and presented as an unsigned decimal number.</td>
				</tr>
				<tr>
					<td>f</td>
					<td>the argument is treated as a float, and presented as a floating-point number (locale aware).</td>
				</tr>
				<tr>
					<td>F</td>
					<td>the argument is treated as a float, and presented as a floating-point number (non-locale aware). Available since PHP 4.3.10 and PHP 5.0.3.</td>
				</tr>
				<tr>
					<td>g</td>
					<td>shorter of %e and %f.</td>
				</tr>
				<tr>
					<td>G</td>
					<td>shorter of %E and %f.</td>
				</tr>
				<tr>
					<td>o</td>
					<td>the argument is treated as an integer, and presented as an octal number.</td>
				</tr>
				<tr>
					<td>s</td>
					<td>the argument is treated as and presented as a string.</td>
				</tr>
				<tr>
					<td>x</td>
					<td>the argument is treated as an integer and presented as a hexadecimal number (with lowercase letters).</td>
				</tr>
				<tr>
					<td>X</td>
					<td>the argument is treated as an integer and presented as a hexadecimal number (with uppercase letters).</td>
				</tr>
			</tbody>
		</table>

		<h4>Examples</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Code</th>
					<th>Result</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="3">Strings</th>
				</tr>
				<tr>
					<td>printf("[%s]", 'monkey');</td>
					<td><pre>[monkey]</pre></td>
					<td>standard string output</td>
				</tr>
				<tr>
					<td>printf("[%10s]", 'monkey');</td>
					<td><pre>[    monkey]</pre></td>
					<td>right-justification with spaces</td>
				</tr>
				<tr>
					<td>printf("[%-10s]", 'monkey');</td>
					<td><pre>[monkey    ]</pre></td>
					<td>left-justification with spaces</td>
				</tr>
				<tr>
					<td>printf("[%010s]", 'monkey');</td>
					<td><pre>[0000monkey]</pre></td>
					<td>zero-padding works on strings too</td>
				</tr>
				<tr>
					<td>printf("[%'#10s]", 'monkey');</td>
					<td><pre>[####monkey]</pre></td>
					<td>use the custom padding character '#'</td>
				</tr>
				<tr>
					<td>printf("[%10.10s]", 'many monkeys');</td>
					<td><pre>[many monke]</pre></td>
					<td>left-justification but with a cutoff of 10 characters</td>
				</tr>

				<tr>
					<th colspan="3">Numbers</th>
				</tr>
				<tr>
					<td>10100111101010011010101101</td>
					<td>printf("%b",  43951789);</td>
					<td># binary representation</td>
				</tr>

				<tr>
					<td>A</td>
					<td>printf("%c",  65);</td>
					<td># print the ascii character, same as chr() function</td>
				</tr>

				<tr>
					<td>43951789</td>
					<td>printf("%d",  43951789);</td>
					<td># standard integer representation</td>
				</tr>

				<tr>
					<td>4.39518e+7</td>
					<td>printf("%e",  43951789);</td>
					<td># scientific notation</td>
				</tr>

				<tr>
					<td>43951789</td>
					<td>printf("%u",  43951789);</td>
					<td># unsigned integer representation of a positive integer</td>
				</tr>

				<tr>
					<td>4251015507</td>
					<td>printf("%u",  -43951789);</td>
					<td># unsigned integer representation of a negative integer</td>
				</tr>

				<tr>
					<td>43951789.000000</td>
					<td>printf("%f",  43951789);</td>
					<td># floating point representation</td>
				</tr>

				<tr>
					<td>247523255</td>
					<td>printf("%o",  43951789);</td>
					<td># octal representation</td>
				</tr>

				<tr>
					<td>43951789</td>
					<td>printf("%s",  43951789);</td>
					<td># string representation</td>
				</tr>

				<tr>
					<td>29ea6ad</td>
					<td>printf("%x",  43951789);</td>
					<td># hexadecimal representation (lower-case)</td>
				</tr>

				<tr>
					<td>29EA6AD</td>
					<td>printf("%X",  43951789);</td>
					<td># hexadecimal representation (upper-case)</td>
				</tr>

				<tr>
					<td>+43951789</td>
					<td>printf("%+d", 43951789);</td>
					<td># sign specifier on a positive integer</td>
				</tr>

				<tr>
					<td>-43951789</td>
					<td>printf("%+d", -43951789);</td>
					<td># sign specifier on a negative integer</pre></td>
				</tr>
			</tbody>
		</table>

	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>