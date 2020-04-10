
		<div id="wordpress">
			<div class="view-container span6">
				<form method="post" data-response="wordpress_response">
					<input type="hidden" name="full" value="1" />
					<div class="control-group">
						<label class="control-label" for="action">On Action</label>
						<div class="controls">
							<input type="text" name="action" value="after_setup_theme" id="action" class="span3" />
							<p class="help-block">Must be <code>after_setup_theme</code> or later</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code">Any PHP entered here will be run through a full pageload, not a "short init"</label>
						<div class="controls">
							<textarea data-ub-codemirror name="code" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input value="Run" type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>

			<div id="wordpress_response" class="view-container span6"></div>
		</div>
