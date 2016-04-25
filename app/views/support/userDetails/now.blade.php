@extends ('support.layouts.default')
@section('main')
<div class="page-content">
<div id="firepad-container"></div>
</div>


<script>
function init() {
  var firepadRef = getExampleRef();
  var codeMirror = CodeMirror(document.getElementById('firepad-container'), { lineWrapping: true });
  var firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
      { richTextToolbar: true, richTextShortcuts: true });
  firepad.on('ready', function() {
    if (firepad.isHistoryEmpty()) {
      firepad.setHtml('<span style="font-size: 24px;">Rich-text editing with <span style="color: red">Firepad!</span></span><br/><br/>Collaborative-editing made easy.\n');
    }
  });
}
function getExampleRef() {
  var ref = new Firebase('https://firepad.firebaseio-demo.com');
  var hash = window.location.hash.replace(/#/g, '');
  if (hash) {
    ref = ref.child(hash);
  } else {
    ref = ref.push();
    window.location = window.location + '#' + ref.key(); // add it as a hash to the URL.
  }
  return ref;
}
init();
</script>

@stop