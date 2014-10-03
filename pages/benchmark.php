
		<div id="benchmark">
			<div class="view-container span6">
				<form method="post" data-response="benchmark_response">
					<input type="hidden" name="action" value="benchmark" />

					<div class="control-group">
						<label class="control-label" for="iterations">Iterations</label>
						<div class="controls">
							<input type="number" name="iterations" value="1000000" id="iterations" class="span2" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code_a">Code A</label>
						<div class="controls">
							<textarea name="code_a" id="code_a" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code_b">Code B</label>
						<div class="controls">
							<textarea name="code_b" id="code_b" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input value="Run" type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>

			<div id="benchmark_response" class="view-container span6"></div>
		</div>
