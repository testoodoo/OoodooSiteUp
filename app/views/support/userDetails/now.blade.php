<!-- @extends ('support.layouts.default')
@section('main') -->
<style type="text/css">
  #firepad-container {
    width: 100%;
    height: 100%;
  }
</style>
<!-- Firebase -->
<script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>

<!-- CodeMirror -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.2.0/codemirror.css" />

<!-- Firepad -->
<link rel="stylesheet" href="https://cdn.firebase.com/libs/firepad/1.2.0/firepad.css" />
<script src="https://cdn.firebase.com/libs/firepad/1.2.0/firepad.min.js"></script>
<div class="page-content">
<div style="hight: 10cm;">
<div id="firepad-container"></div></div>
</div>
<script>
function init() {

  var firepadRef = getExampleRef();
  // TODO: Replace above line with:
  // var firepadRef = new Firebase('<YOUR FIREBASE URL>');

  //// Create CodeMirror (with lineWrapping on).
  var codeMirror = CodeMirror(document.getElementById('firepad-container'), {
    lineWrapping: true
  });

  //// Create Firepad (with rich text toolbar and shortcuts enabled).
  var firepad = Firepad.fromCodeMirror(firepadRef, codeMirror, {
    richTextToolbar: true,
    richTextShortcuts: true
  });

  //// Initialize contents.
  firepad.on('ready', function() {
    if (firepad.isHistoryEmpty()) {
      firepad.setHtml('<span style="font-size: 24px;">Rich-text editing with <span style="color: red">Firepad!</span></span><br/><br/>Collaborative-editing made easy.\n');
    }
  });
}

// Helper to get hash from end of URL or generate a random one.
function getExampleRef() {
  var ref = new Firebase('https://firepad.firebaseio-demo.com');
  var hash = window.location.hash.replace(/#/g, '');
  if (hash) {
    ref = ref.child(hash);
  } else {
    ref = ref.push(); // generate unique location.
    window.location = window.location + '#' + ref.key(); // add it as a hash to the URL.
  }
  return ref;
}

init();
</script>
