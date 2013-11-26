<?php
$url = get_transient( 'es_url' ) ?: 'http://localhost:9200';
$last_search = get_transient( 'es_query' );
# Do something with $last_search
?>


		<div id="elasticsearch">
			<div class="view-container">
				<form method="post" data-response="elasticsearch_response">
					<input type="hidden" name="action" value="elasticsearch" />
					<div class="control-group">
						<label class="control-label" for="es_url">elasticsearch URL</label>
						<div class="controls">
							<input type="text" name="es_url" value="<?php echo $url ?>" id="es_url" class="span6" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="es_query">elasticsearch JSON Query</label>
						<div class="controls">
							<textarea name="es_query" id="es_query" rows="8" cols="40" class="span12"><?php echo $last_search ?></textarea>
						</div>
					</div>
					<div class="form-actions">
						<input value="Search" type="submit" class="btn btn-primary" />
					</div>
				</form>
			</div>

			<div id="elasticsearch_response" class="view-container"></div>
		</div>
