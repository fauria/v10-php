
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>V10-PHP Lightweight Framework</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Lightweight PHP Framework">
	<meta name="author" content="Fernando Alvarez-Uria">

	<!-- Le styles -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="assets/css/v10.css" rel="stylesheet">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/icons/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/icons/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/icons/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="assets/icons/apple-touch-icon-57-precomposed.png">

		<script type="text/javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="assets/js/v10.js"></script>

		<link rel="shortcut icon" href="assets/icons/favicon.png">
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="#">V10-PHP</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li class="active"><a href="main">V10</a></li>
							<li><a href="tools/moadmin.php">PHPMoAdmin</a></li>
							<li><a href="tools/sqlbuddy">SQLBuddy</a></li>
							<li><a href="http://v10-php.com">Home</a></li>
							<li><a href="https://github.com/fauria/v10-php/">Github</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">Secciones</li>
							<li><a href="#bienvenida">Bienvenida</a></li>
							<li><a href="#servicios">Servicios</a></li>
							<li><a href="#elementos">Elementos</a></li>
							<li><a href="#ajax">Ajax</a></li>
							<li><a href="#config">Configuración</a></li>
							<li><a href="#funciones">Funciones Integradas</a></li>
							<li><a href="#db">Funciones de MongoDB</a></li>
							<li class="nav-header">Herramientas</li>
							<li><a href="tools/moadmin.php">PHPMoAdmin</a></li>
							<li><a href="tools/sqlbuddy">SQLBuddy</a></li>
						</ul>
					</div><!--/.well -->
				</div><!--/span-->
				<div class="span9">
					<div id="bienvenida" class="hero-unit">
						<h1>Bienvenido a V10-PHP!</h1>
						<p>A continuación se muestran algunas de las características del framework, así como una referencia a sus distintas funciones y componentes. Estos ficheros pueden tomarse como punto de partida para el proyecto.</p>
						<p><a href="https://github.com/fauria/v10-php/" class="btn btn-primary btn-large">Ver en Github &raquo;</a></p>
					</div>
					<div id="servicios" class="row-fluid">
						<div class="span4">
							<h2>MongoDB</h2>
							<?if($is_mongodb):?>
							<p>El servicio MongoDB se encuentra <strong>arrancado</strong>.</p>
							<p><img width="200" src="assets/img/mongodb.png"></p>
							<?else:?>
							<p>El servicio MongoDB se encuentra <strong>parado</strong>.</p>
							<p><img width="200" src="assets/img/mongodb_bw.png"></p>							
							<?endif?>
							<p><a class="btn" href="http://mongodb.org">Visitar sitio &raquo;</a></p>
						</div><!--/span-->
						<div class="span4">
							<h2>Redis</h2>
							
							<p>
								<?if($is_redis):?>
								<p>El servicio Redis se encuentra <strong>arrancado</strong>.</p>
								<img width="200" src="assets/img/redis.png">
								<?else:?>
								<p>El servicio Redis se encuentra <strong>parado</strong>.</p>
								<img width="200" src="assets/img/redis_bw.png">
								<?endif?>
								</p>
							<p><a class="btn" href="http://mysql.com">Visitar sitio &raquo;</a></p>
						</div><!--/span-->
						<div class="span4">
							<h2>MySQL</h2>

							<p>
								<?if($is_mysql):?>
								<p>El servicio MySQL se encuentra <strong>arrancado</strong>.</p>								
								<img width="200" src="assets/img/mysql.png">
								<?else:?>
								<p>El servicio MySQL se encuentra <strong>parado</strong>.</p>																
								<img width="200" src="assets/img/mysql_bw.png">
								<?endif?>
							</p>
							<p><a class="btn" href="http://mysql.com">Visitar sitio &raquo;</a></p>
						</div><!--/span-->
					</div><!--/row-->
					
					<div id="elementos" class="row-fluid">
						<div class="span4">
							<h2>Documentos</h2>
							<p>Los documentos se guardan en el directorio <code>documents/</code>. Para hacer uso de ellos, se crea una clase con el mismo nombre que el fichero, que extienda la clase Db. Por ejemplo:<br><code>class Documento extends Db()</code><br/>
								A partir de aquí, podremos ejecutar las funciones de V10 relacionadas con MongoDB.
								</p>
						</div><!--/span-->
						<div class="span4">
							<h2>Controladores</h2>
							<p>Los controladores se guardan en el directorio <code>controllers/</code>. Pueden anidarse en subdirectorios, y estos se especificaran de forma normal en la URL.<br>Para crear un controlador basta con darle al fichero el mismo nombre que la clase: <code>class C1()</code><br/>
								Las funciones del controlador se especificarán en el siguiente segmento de URL, y los parámetros en los sucesivos: <code>http://example.com/subdir/c1/f1/arg1/arg2</code>
								<br>y después:<br>
								<code>
									public funtion f1($arg1, $arg2)
								</code>	
								</p>
						</div>
						<div class="span4">
							<h2>Vistas</h2>
							<p>Las vistas son ficheros simples php que se encuentran en el directorio <code>views/</code>. <br>Se cargan llamando a <code>load_view(vista)</code>. Opcionalmente, puede pasarse un array como parámetro con los datos a insertar en la vista.</p>
						</div><!--/span-->
					</div><!--/row-->
					
					<div id="ajax" class="row-fluid">
						<div class="span4">
							<h2>Ajax</h2>
							<p id="resultado"></p>
							<pre id="array"></pre>
							<p><a class="btn" id="probar">Volver a probar &raquo;</a></p>			
						</div><!--/span-->
						<div class="span8">
							<h2>El controlador Ajax</h2>
							<p>El framework V10 proporciona un controlador de ejemplo  <code>controllers/ajax</code> que permite probar esta funcionalidad.</p>
						</div><!--/span-->

					</div><!--/row-->
				
					<div id="config" class="row-fluid">
						<div class="span12">
							<h2>Configuración</h2>
							<p>Están disponibles las siguientes directivas de configuración:</p>
							<table class="table">
								<thead>
									<tr>
										<th>Directiva</th>
										<th>Valor actual</th>
										<th>Descripción</th>
									</tr>
								</thead>
								<tbody>
									<tr id="default_controller">
										<td><code>default_controller</code></td>
										<td><?=default_controller?></td>
										<td>Controlador por defecto si no se especifica uno.</td>
									</tr>
									<tr id="default_method">
										<td><code>default_method</code></td>
										<td><?=default_method?></td>
										<td>Método por defecto si no se especifica uno.</td>
									</tr>
									<tr id="base_host">
										<td><code>base_host</code></td>
										<td><?=base_host?></td>
										<td>Host de la aplicación.</td>
									</tr>
									<tr id="base_folder">
										<td><code>base_folder</code></td>
										<td><?=base_folder?></td>
										<td>Directorio base.</td>
									</tr>
									<tr id="base_url">
										<td><code>base_url</code></td>
										<td><?=base_url?></td>
										<td>URL base.</td>
									</tr>
									<tr id="mongodb_host">
										<td><code>mongodb_host</code></td>
										<td><?=mongodb_host?></td>
										<td>Host de MongoDB.</td>
									</tr>
									<tr id="redis_port">
										<td><code>mongodb_port</code></td>
										<td><?=mongodb_port?></td>
										<td>Puerto de MongoDB.</td>
									</tr>
									<tr id="default_database">
										<td><code>default_database</code></td>
										<td><?=default_database?></td>
										<td>Base de datos de MongoDB por defecto.</td>
									</tr>
									<tr id="default_collection">
										<td><code>default_collection</code></td>
										<td><?=default_collection?></td>
										<td>Colección de MongoDB por defecto</td>
									</tr>
									<tr id="array_mode">
										<td><code>array_mode</code></td>
										<td><?=array_mode?></td>
										<td>Recuperar como array los datos de MongoDB.</td>
									</tr>
									<tr id="redis_host">
										<td><code>redis_host</code></td>
										<td><?=redis_host?></td>
										<td>Host de Redis.</td>
									</tr>
									<tr id="redis_port">
										<td><code>redis_port</code></td>
										<td><?=redis_port?></td>
										<td>Puerto de Redis.</td>
									</tr>
									<tr id="mysql_host">
										<td><code>mysql_host</code></td>
										<td><?=mysql_host?></td>
										<td>Host de MySQL.</td>
									</tr>
									<tr id="redis_port">
										<td><code>mysql_port</code></td>
										<td><?=mysql_port?></td>
										<td>Puerto de MySQL.</td>
									</tr>
									<tr id="mysql_database">
										<td><code>mysql_database</code></td>
										<td><?=mysql_database?></td>
										<td>Base de datos por defecto de MySQL.</td>
									</tr>
									<tr id="mysql_user">
										<td><code>mysql_user</code></td>
										<td><?=mysql_user?></td>
										<td>Usuario de MySQL.</td>
									</tr>
									<tr id="mysql_pass">
										<td><code>mysql_pass</code></td>
										<td><?=mysql_pass?></td>
										<td>Password de MySQL</td>
									</tr>
									<tr id="allowed_extensions">
										<td><code>allowed_extensions</code></td>
										<td><?=allowed_extensions?></td>
										<td>Extensiones de ficheros reconocidas.</td>
									</tr>
									<tr id="use_v10_error_handler">
										<td><code>use_v10_error_handler</code></td>
										<td><?=use_v10_error_handler?></td>
										<td>Utilizar el manejador de errores de V10.</td>
									</tr>
									<tr id="load_v10_functions">
										<td><code>load_v10_functions</code></td>
										<td><?=load_v10_functions?></td>
										<td>Funciones de V10 a cargar.</td>
									</tr>
									
								</tbody>
							</table>
						
						</div>
					</div>
				
				<div id="funciones" class="row-fluid">
						<div class="span12">
							<h2>Funciones integradas</h2>
							<p>Están disponibles las siguientes funciones:</p>
							<table class="table">
								<thead>
									<tr>
										<th>Función</th>
										<th>Parámetros</th>
										<th>Descripción</th>
									</tr>
								</thead>
								<tbody>
									<tr id="">
										<td><code>load_controller</code></td>
										<td><code>$controller, $folder = null</code></td>
										<td>Carga un controlador.</td>
									</tr>
									<tr id="">
										<td><code>load_view</code></td>
										<td><code>$view, $data = array()</code></td>
										<td>Carga una vista.</td>
									</tr>
									<tr id="">
										<td><code>dump_view</code></td>
										<td><code>$view, $data = array()</code></td>
										<td>Vuelca una vista en una variable.</td>
									</tr>
									<tr id="">
										<td><code>dump</code></td>
										<td><code>$cvar</code></td>
										<td>Vuelca una variable.</td>
									</tr>
									<tr id="">
										<td><code>load_model</code></td>
										<td><code>$model, $folder = null</code></td>
										<td>Carga un modelo.</td>
									</tr>
									<tr id="">
										<td><code>load_document</code></td>
										<td><code>$document, $folder = null</code></td>
										<td>Carga un documento.</td>
									</tr>
									<tr id="">
										<td><code>load_lang</code></td>
										<td><code>$iso31661a2</code></td>
										<td>Carga un lenguaje.</td>
									</tr>
									<tr id="">
										<td><code>uri_segment</code></td>
										<td><code>$n = 1</code></td>
										<td>Devuelve un segmento de URL.</td>
									</tr>
									<tr id="">
										<td><code>current_request</code></td>
										<td></td>
										<td>Devuelve la petición actual.</td>
									</tr>
									<tr id="">
										<td><code>xss_clean</code></td>
										<td><code>$data</code></td>
										<td>Limpia una cadena de tags xss.</td>
									</tr>
									<tr id="">
										<td><code>http_header</code></td>
										<td><code>$code</code></td>
										<td>Lanza una cabecera HTTP 1.1.</td>
									</tr>
									<tr id="">
										<td><code>check_socket</code></td>
										<td><code>$host, $port</code></td>
										<td>Comprueba un socket.</td>
									</tr>																																	
								</tbody>
							</table>
						
						</div>
					</div>
				
				
				<div id="db" class="row-fluid">
						<div class="span12">
							<h2>Funciones de MongoDB</h2>
							<p>Están disponibles las siguientes funciones. Los parámetros <code>$id</code> pueden especificarse tanto de tipo MongoID como cadena. Los valores devueltos dependerán de la directiva de configuración <code>array_mode</code>.</p>
							<table class="table">
								<thead>
									<tr>
										<th>Función</th>
										<th>Parámetros</th>
										<th>Descripción</th>
									</tr>
								</thead>
								<tbody>
									<tr id="">
										<td><code>get_all</code></td>
										<td><code>$sort = array()</code></td>
										<td>Recupera todos los documentos.</td>
									</tr>
									<tr id="">
										<td><code>get_one($id)</code></td>
										<td><code>$view, $data = array()</code></td>
										<td>Recupera un documento.</td>
									</tr>
									<tr id="">
										<td><code>get_count($criteria = array())</code></td>
										<td><code>$view, $data = array()</code></td>
										<td>Cuenta el número de documentos bajo un critero.</td>
									</tr>
									<tr id="">
										<td><code>run_query($criteria = array(), $skip = 0, $limit = false)</code></td>
										<td><code>$cvar</code></td>
										<td>Ejecuta una consulta.</td>
									</tr>
									<tr id="">
										<td><code>get_binary($id)</code></td>
										<td><code>$model, $folder = null</code></td>
										<td>Recupera un elemento de GridFS.</td>
									</tr>
									<tr id="">
										<td><code>get_attribute($attr, $id)</code></td>
										<td><code>$document, $folder = null</code></td>
										<td>Recupera un atributo de un documento.</td>
									</tr>
									<tr id="">
										<td><code>add($item)</code></td>
										<td><code>$iso31661a2</code></td>
										<td>Añade un documento.</td>
									</tr>
									<tr id="">
										<td><code>update($id, $data)</code></td>
										<td><code>$n = 1</code></td>
										<td>Actualiza un documento.</td>
									</tr>
									<tr id="">
										<td><code>delete($id)</code></td>
										<td></td>
										<td>Elimina un documento.</td>
									</tr>
									<tr id="">
										<td><code>upload_file($file, $metadata = array('metadata' => array()))</code></td>
										<td><code>$data</code></td>
										<td>Almacena un elemento en GridFS.</td>
									</tr>																																				
								</tbody>
							</table>
						
						</div>
					</div>
				
			
			
			
			</div><!--/row-->


			<hr>

			<footer>
				<p>Por Fernando Álvarez-Uria - fernando@vacadiez.com</p>
			</footer>

		</div><!--/.fluid-container-->


	</body>
	</html>
