
<div id="time">
	<div class="view-container span6">
		<form method="post" data-response="time_response" class="form-vertical">
			<input type="hidden" name="action" value="time" />
			<legend>Format</legend>
			<div class="control-group">
				<label class="control-label" for="date_format">Format</label>
				<div class="controls">
					<input type="text" name="date_format" value="Y-m-d H:i:s T" id="date_format" class="span3 monospace" />
				</div>
				<a href="#formatModal" role="button" class="btn" data-toggle="modal">Reference</a>
			</div>

			<div class="control-group">
				<label class="control-label" for="date_timezone">Timezone for formatted output</label>
				<div class="controls">
					<select name="date_timezone" id="date_timezone" class="span3">
						<?php echo wp_timezone_choice( 'UTC' ); ?>
					</select>
				</div>
			</div>

			<legend>Timestamp</legend>
			<div class="control-group">
				<label class="control-label" for="timestamp">Timestamp</label>
				<div class="controls">
					<input type="text" name="timestamp" value="" id="timestamp" class="span3 monospace" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="strtotime"><code>strtotime</code> string (assumed UTC unless the string incldues a timezone)</label>
				<div class="controls">
					<input type="text" name="strtotime" value="" id="strtotime" class="span3 monospace" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Make timestamp via <code>mktime</code> (UTC)</label>
				<div class="controls">
					<input type="text" name="mktime[0]" value="" placeholder="hh" size="2" class="span1" />
					<input type="text" name="mktime[1]" value="" placeholder="mm" size="2" class="span1" />
					<input type="text" name="mktime[2]" value="" placeholder="ss" size="2" class="span1" />
					<input type="text" name="mktime[3]" value="" placeholder="mm" size="2" class="span1" />
					<input type="text" name="mktime[4]" value="" placeholder="dd" size="2" class="span1" />
					<input type="text" name="mktime[5]" value="" placeholder="yyyy" size="4" class="span1" />
				</div>
			</div>

			<div class="form-actions">
				<input name="time" value="Process" type="submit" class="btn" />
			</div>
		</form>
	</div>

	<div id="time_response" class="view-container span6">
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th scope="row">Timestamp</th>
				<td><?php echo time() ?></td>
			</tr>
			<tr>
				<th scope="row">mktime</th>
				<td><code>mktime( <?php echo date( "G, i, s, n, j, Y" ) ?> )</code></td>
			</tr>
			<tr>
				<th scope="row">Formatted</th>
				<td><?php echo date( 'Y-m-d H:i:s T' ) ?></td>
			</tr>
			<tr>
				<th scope="row">Local</th>
				<td><?php echo wp_date( 'Y-m-d H:i:s T' ) ?></td>
			</tr>
		</tbody>
	</table>
	</div>
</div>

<div id="formatModal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>date() Format Quick Ref</h3>
	</div>
	<div class="modal-body">
		<table class="table table-bordered">
	        <caption><strong>The following characters are recognized in the <em><code class="parameter">format</code></em> parameter string</strong></caption>

	        <thead>
	        	<tr>
	        		<th><em><code class="parameter">format</code></em> character</th>
	        		<th>Description</th>
	        		<th>Example returned values</th>
	        	</tr>
	        </thead>

	        <tbody class="tbody">
	        	<tr>
	        		<th colspan="3">Day</th>
	        	</tr>

	        	<tr>
	        		<td><em>d</em></td>
	        		<td>Day of the month, 2 digits with leading zeros</td>
	        		<td><em>01</em> to <em>31</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>D</em></td>
	        		<td>A textual representation of a day, three letters</td>
	        		<td><em>Mon</em> through <em>Sun</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>j</em></td>
	        		<td>Day of the month without leading zeros</td>
	        		<td><em>1</em> to <em>31</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>l</em> (lowercase 'L')</td>
	        		<td>A full textual representation of the day of the week</td>
	        		<td><em>Sunday</em> through <em>Saturday</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>N</em></td>
	        		<td>ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)</td>
	        		<td><em>1</em> (for Monday) through <em>7</em> (for Sunday)</td>
	        	</tr>

	        	<tr>
	        		<td><em>S</em></td>
	        		<td>English ordinal suffix for the day of the month, 2 characters</td>
	        		<td>
	        			<em>st</em>, <em>nd</em>, <em>rd</em> or
	        			<em>th</em>.  Works well with <em>j</em>
	        		</td>
	        	</tr>

	        	<tr>
	        		<td><em>w</em></td>
	        		<td>Numeric representation of the day of the week</td>
	        		<td><em>0</em> (for Sunday) through <em>6</em> (for Saturday)</td>
	        	</tr>

	        	<tr>
	        		<td><em>z</em></td>
	        		<td>The day of the year (starting from 0)</td>
	        		<td><em>0</em> through <em>365</em></td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Week</th>
	        	</tr>

	        	<tr>
	        		<td><em>W</em></td>
	        		<td>ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)</td>
	        		<td>Example: <em>42</em> (the 42nd week in the year)</td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Month</th>
	        	</tr>

	        	<tr>
	        		<td><em>F</em></td>
	        		<td>A full textual representation of a month, such as January or March</td>
	        		<td><em>January</em> through <em>December</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>m</em></td>
	        		<td>Numeric representation of a month, with leading zeros</td>
	        		<td><em>01</em> through <em>12</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>M</em></td>
	        		<td>A short textual representation of a month, three letters</td>
	        		<td><em>Jan</em> through <em>Dec</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>n</em></td>
	        		<td>Numeric representation of a month, without leading zeros</td>
	        		<td><em>1</em> through <em>12</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>t</em></td>
	        		<td>Number of days in the given month</td>
	        		<td><em>28</em> through <em>31</em></td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Year</th>
	        	</tr>

	        	<tr>
	        		<td><em>L</em></td>
	        		<td>Whether it's a leap year</td>
	        		<td><em>1</em> if it is a leap year, <em>0</em> otherwise.</td>
	        	</tr>

	        	<tr>
	        		<td><em>o</em></td>
	        		<td>
	        			ISO-8601 year number. This has the same value as
	        			<em>Y</em>, except that if the ISO week number
	        			(<em>W</em>) belongs to the previous or next year, that year
	        			is used instead. (added in PHP 5.1.0)
	        		</td>
	        		<td>Examples: <em>1999</em> or <em>2003</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>Y</em></td>
	        		<td>A full numeric representation of a year, 4 digits</td>
	        		<td>Examples: <em>1999</em> or <em>2003</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>y</em></td>
	        		<td>A two digit representation of a year</td>
	        		<td>Examples: <em>99</em> or <em>03</em></td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Time</th>
	        	</tr>

	        	<tr>
	        		<td><em>a</em></td>
	        		<td>Lowercase Ante meridiem and Post meridiem</td>
	        		<td><em>am</em> or <em>pm</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>A</em></td>
	        		<td>Uppercase Ante meridiem and Post meridiem</td>
	        		<td><em>AM</em> or <em>PM</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>B</em></td>
	        		<td>Swatch Internet time</td>
	        		<td><em>000</em> through <em>999</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>g</em></td>
	        		<td>12-hour format of an hour without leading zeros</td>
	        		<td><em>1</em> through <em>12</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>G</em></td>
	        		<td>24-hour format of an hour without leading zeros</td>
	        		<td><em>0</em> through <em>23</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>h</em></td>
	        		<td>12-hour format of an hour with leading zeros</td>
	        		<td><em>01</em> through <em>12</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>H</em></td>
	        		<td>24-hour format of an hour with leading zeros</td>
	        		<td><em>00</em> through <em>23</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>i</em></td>
	        		<td>Minutes with leading zeros</td>
	        		<td><em>00</em> to <em>59</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>s</em></td>
	        		<td>Seconds, with leading zeros</td>
	        		<td><em>00</em> through <em>59</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>u</em></td>
	        		<td>
	        			Microseconds (added in PHP 5.2.2). Note that
	        			<span class="function"><strong>date()</strong></span> will always generate
	        			<em>000000</em> since it takes an <span class="type"><a href="http://php.net/manual/en/language.types.integer.php" class="type integer">integer</a></span>
	        			parameter, whereas  <span class="methodname"><a href="http://php.net/manual/en/datetime.format.php" class="methodname">DateTime::format()</a></span> does
	        			support microseconds.
	        		</td>
	        		<td>Example: <em>654321</em></td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Timezone</th>
	        	</tr>

	        	<tr>
	        		<td><em>e</em></td>
	        		<td>Timezone identifier (added in PHP 5.1.0)</td>
	        		<td>Examples: <em>UTC</em>, <em>GMT</em>, <em>Atlantic/Azores</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>I</em> (capital i)</td>
	        		<td>Whether or not the date is in daylight saving time</td>
	        		<td><em>1</em> if Daylight Saving Time, <em>0</em> otherwise.</td>
	        	</tr>

	        	<tr>
	        		<td><em>O</em></td>
	        		<td>Difference to Greenwich time (GMT) in hours</td>
	        		<td>Example: <em>+0200</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>P</em></td>
	        		<td>Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3)</td>
	        		<td>Example: <em>+02:00</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>T</em></td>
	        		<td>Timezone abbreviation</td>
	        		<td>Examples: <em>EST</em>, <em>MDT</em> ...</td>
	        	</tr>

	        	<tr>
	        		<td><em>Z</em></td>
	        		<td>Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.</td>
	        		<td><em>-43200</em> through <em>50400</em></td>
	        	</tr>

	        	<tr>
	        		<th colspan="3">Full Date/Time</th>
	        	</tr>

	        	<tr>
	        		<td><em>c</em></td>
	        		<td>ISO 8601 date (added in PHP 5)</td>
	        		<td>2004-02-12T15:19:21+00:00</td>
	        	</tr>

	        	<tr>
	        		<td><em>r</em></td>
	        		<td><a href="http://www.faqs.org/rfcs/rfc2822" class="link external">»&nbsp;RFC 2822</a> formatted date</td>
	        		<td>Example: <em>Thu, 21 Dec 2000 16:01:07 +0200</em></td>
	        	</tr>

	        	<tr>
	        		<td><em>U</em></td>
	        		<td>Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</td>
	        		<td>See also  <span class="function"><a href="http://php.net/manual/en/function.time.php" class="function">time()</a></span></td>
	        	</tr>

	        </tbody>

	    </table>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
