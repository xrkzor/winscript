var i = 0;

        function increment() {
            i += 1;
        }

    function addfieldFunction() {
      var r = document.createElement('div');
      var y = document.createElement("label");
      var z = document.createElement("INPUT");
      y.setAttribute("for", "champ{{fields|length}}");
      z.setAttribute("type", "text");
      z.setAttribute("name", "champs[{{fields|length}}]");
      z.setAttribute("id", "champ{{fields|length}}");
      increment();
      y.setAttribute("name", ""champ{{fields|length}}[ " + i + " ][0]"); //Keep attribute in lower case
      r.appendChild(y);
      z.setAttribute("name", "champs[{{fields|length}}][ " + i + " ][1]"); //Keep attribute in lower case
      r.appendChild(z);
      document.getElementById("col-sm-4").appendChild(r);