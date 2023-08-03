				<br /><br /><br />
				<!--<div id="footer" name="footer" class="navbar navbar-fixed-bottom" style="vertical-align: middle;text-align: center;background-color: black; margin-bottom: -35px; font-size: 10px;">
					<span style="color: white;">Corrales de Romero S.A. <?php echo date("Y"); ?> Copyright &copy; - Todos los derechos reservados</span>
				</div>-->
					
                                <div id="footer" name="footer" class="footer" style="position: fixed;">
					<div class="pull-right">                                            
						<strong>MyWork </strong>
						<strong>&copy; <?php echo date("Y"); ?> | </strong>Todos los derechos reservados
					</div>
				</div>
			
			</div>
		</div>
	
		<!-- Mainly scripts -->
		<!--<script src="inspinia/js/jquery-3.1.1.min.js"></script>-->
                <?php 
                if ($_SESSION['timeline'] == 1) { 
                    unset($_SESSION['timeline']); 
                } else { 
                    echo '<script src="inc/js/jquery-3.2.1.js"></script>';
                } ?>
		<script src="inc/bootstrap/js/select2.min.js"></script>
		<script src="inspinia/js/bootstrap.min.js"></script>
		<script src="inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script src="inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		<!-- Custom and plugin javascript -->
		<script src="inspinia/js/inspinia.js"></script>
		<script src="inspinia/js/plugins/pace/pace.min.js"></script>
                
                <!-- Flot -->
                <script src="inspinia/js/plugins/flot/jquery.flot.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.spline.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.resize.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.pie.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.symbol.js"></script>
                <script src="inspinia/js/plugins/flot/jquery.flot.time.js"></script>

                <!-- Peity -->
                <script src="inspinia/js/plugins/peity/jquery.peity.min.js"></script>
                
                <script src="inspinia/js/plugins/select2/select2.full.min.js"></script>
                
                <script src="inspinia/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
                <script src="inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>
                
                <script>
                    $(".select2").select2({
                        //dropdownParent: $("#dataRegister")
                    });
                    $("#helpbutton").click(function (){
                        $("#helpModal").modal('show');
                    });
                </script>
    </body>
</html>