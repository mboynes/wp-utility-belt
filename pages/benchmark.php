
		<div id="benchmark">
			<div class="view-container span6">
				<form method="post" data-response="benchmark_response">
					<input type="hidden" name="action" value="benchmark" />

					<div class="control-group">
						<label class="control-label" for="iterations">Iterations</label>
						<div class="controls">
							<input type="number" name="iterations" value="1000" id="iterations" class="span2" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code_a">Environment (e.g. shared variables, functions, etc.)</label>
						<div class="controls codemirror-height-auto">
							<textarea data-ub-codemirror name="env" id="env" rows="4" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code_a">Test A</label>
						<div class="controls codemirror-height-200">
							<textarea data-ub-codemirror name="code_a" id="code_a" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="code_b">Test B</label>
						<div class="controls codemirror-height-200">
							<textarea data-ub-codemirror name="code_b" id="code_b" rows="8" cols="40" class="span6"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input value="Run" type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>

			<div id="benchmark_response" class="view-container span6"></div>
		</div>
