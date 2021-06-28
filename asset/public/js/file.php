<p>Name: </p><input id="name" type="text"/>

<p>Select a Thing:</p>

<select name="thingselect" id="thingselect">
  <option value="thing1">Thing 1</option>
  <option value="thing2">Thing 2</option>
  <option value="thing3">Thing 3</option>
</select>
<br>
<br>

<button id="insert-content">Insert This Content! (Dialog will stay open)</button>
<script>
  window.addEventListener('message', function (event) {
    console.log(event.data)
    if (event.data.mceAction ==='customInsertAndClose'){
      var value = {
        name: document.getElementById('name').value,
        thing: document.getElementById('thingselect').value
      };
  
      window.parent.postMessage({
        mceAction: 'execCommand',
        cmd: 'iframeCommand',
        value 
      }, origin);

      window.parent.postMessage({
            mceAction: 'close'
        }, origin);
    }
  });

  document.getElementById('insert-content').addEventListener('click', function (event) {
    var value = {
      name: document.getElementById('name').value,
      thing: document.getElementById('thingselect').value
    };
  
    window.parent.postMessage({
      mceAction: 'execCommand',
      cmd: 'iframeCommand',
      value 
    }, origin);
  });

</script>