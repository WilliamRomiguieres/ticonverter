<script src="codemirror-5.6/lib/codemirror.js"></script>
	<script src="codemirror-5.6/mode/tibasic/tibasic.js"></script>
	<script src="codemirror-5.6/addon/selection/active-line.js"></script>
	<script type="text/javascript">
		var editor = CodeMirror.fromTextArea(document.getElementById("TTREA_code"), {
			mode: "tibasic",
			styleActiveLine: true,
			lineNumbers: true,
			theme: "3024-night"
		});
	</script>
</body>
</html>
