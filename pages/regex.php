
<div id="regex">
	<div class="view-container span6">
		<form method="post" data-response="regex_response">
			<input type="hidden" name="action" value="regex" />
			<div class="control-group">
				<label class="control-label" for="expression">Regex</label>
				<div class="controls">
					<textarea name="expression" id="expression" rows="3" cols="40" class="span6"></textarea>
					<p class="help-block">Don't forget to wrap your expression, e.g. /expression/</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="replace">Replace</label>
				<div class="controls">
					<textarea name="replace" id="replace" rows="3" cols="40" class="span6"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="content">Content</label>
				<div class="controls">
					<textarea name="content" id="content" rows="3" cols="40" class="span6"></textarea>
				</div>
			</div>
			<div class="form-actions">
				<input name="regex" value="Match" type="submit" class="btn" />
				<input name="regex" value="Match All" type="submit" class="btn" />
				<input name="regex" value="Replace" type="submit" class="btn" />
			</div>
		</form>
	</div>

	<div id="regex_response" class="view-container span6"></div>
</div>
