<?php get_header() ?>

		<div id="home">
			<div class="view-container span6">
				<form method="post" data-response="home_response">
					<input type="hidden" name="action" value="home" />
					<div class="control-group">
						<label class="control-label" for="code">Any PHP entered here will be processed through a WordPress "short init" request</label>
						<div class="controls">
							<textarea data-ub-codemirror name="code" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input value="Run" type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>

			<div id="home_response" class="view-container span6"></div>
		</div>

<?php get_footer() ?>
