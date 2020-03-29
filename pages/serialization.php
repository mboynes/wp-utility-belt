
<div id="serialization">
	<div class="view-container span6">
		<form method="post" data-response="serial_response">
			<input type="hidden" name="action" value="serialization" />
			<div class="control-group">
				<label class="control-label" for="serializee">String or Expression</label>
				<div class="controls">
					<textarea name="serializee" id="serializee" rows="3" cols="40" class="span6 monospace"></textarea>
					<p class="help-block">An expression to serialize can be any PHP that could be returned by a function, like array('foo','bar').</p>
				</div>
			</div>
			<div class="form-actions">
				<input name="serialization" value="Serialize" type="submit" class="btn" />
				<input name="serialization" value="Unserialize" type="submit" class="btn" />
				<input name="serialization" value="JSON Encode" type="submit" class="btn" />
				<input name="serialization" value="JSON Decode" type="submit" class="btn" />
			</div>
		</form>
	</div>

	<div id="serial_response" class="view-container span6"></div>
</div>
