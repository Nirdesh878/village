var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns=""><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (name, table_fed, table_cluster, table_shg, table_family, filename) {
            if (!name.nodeType) name = document.getElementById(name)
            if (!table_fed.nodeType) table_fed = document.getElementById(table_fed)
            if (!table_cluster.nodeType) table_cluster = document.getElementById(table_cluster)
            if (!table_shg.nodeType) table_shg = document.getElementById(table_shg)
            if (!table_family.nodeType) table_family = document.getElementById(table_family)
            var newtable = document.createElement("table");
            var tbody = document.createElement("tbody");
            var row = document.createElement("tr");
            var row1 = document.createElement("tr");
            var row2 = document.createElement("tr");
            var row3 = document.createElement("tr");
            var row4 = document.createElement("tr");
            var row5 = document.createElement("tr");
            var row6 = document.createElement("tr");
            var cell2 = document.createElement("td");
            var cell3 = document.createElement("td");
            var cell4 = document.createElement("td");
            var cell5 = document.createElement("td");
            var cell6 = document.createElement("td");
            var cell7 = document.createElement("td");
            var cell8 = document.createElement("td");
            var cell9 = document.createElement("td");
            var cell10 = document.createElement("td");
            var cell11 = document.createElement("td");
            var cell12 = document.createElement("td");
            var cell13 = document.createElement("td");
            cell2.innerHTML = "Country";
            cell3.innerHTML  = ($("#country option:selected").text() != "--Select--") ? $("#country option:selected").text() : "-";
            cell4.innerHTML = "State";
            cell5.innerHTML  = ($("#state option:selected").text() != "--Select--") ? $("#state option:selected").text() : "-";
            cell6.innerHTML = "District";
            cell7.innerHTML = ($("#district option:selected").text() != "--Select--") ? $("#district option:selected").text() : "-";
            cell8.innerHTML = "Agency";
            cell9.innerHTML = ($("#agency").val() != "") ? $("#agency").val() : "-";
            cell10.innerHTML = "From";
            cell11.innerHTML  = ($("#dt_from").text() != "") ? $("dt_from").text() : "-";
            cell12.innerHTML = "To";
            cell13.innerHTML  = ($("#dt_to").text() != "") ? $("#dt_to").text() : "-";

            row1.appendChild(cell2); row1.appendChild(cell3);
            row2.appendChild(cell4); row2.appendChild(cell5);
            row3.appendChild(cell6); row3.appendChild(cell7);
            row4.appendChild(cell8); row4.appendChild(cell9);
            row5.appendChild(cell10); row5.appendChild(cell11);
            row6.appendChild(cell12); row5.appendChild(cell13);
            // row6.appendChild(cell12); row6.appendChild(cell13);
            row.setAttribute("style", "background-color: black;color: white; font-family:Calibri;");
            var cell1 = document.createElement("td");

            cell1.colSpan = 12;
            cell1.innerHTML = "Federation";
            row.appendChild(cell1);
            tbody.appendChild(row1);
            tbody.appendChild(row2);
            tbody.appendChild(row3);
            tbody.appendChild(row4);
            tbody.appendChild(row5);
            tbody.appendChild(row6);
            tbody.appendChild(row);
            newtable.appendChild(tbody);
            var clonedTable = newtable.cloneNode(true);
            var clonedtable_fed = table_fed.cloneNode(true);
            var clonedtable_cluster = table_cluster.cloneNode(true);
            var clonedtable_shg = table_shg.cloneNode(true);
            var clonedtable_family = table_family.cloneNode(true);
            clonedTable.appendChild(clonedtable_fed);
            var row = document.createElement("tr");
            var tbody = document.createElement("tbody");
            var newtable = document.createElement("table");
            row.setAttribute("style", "background-color: black;color: white; font-family:Calibri;");
            var cell1 = document.createElement("td");
            cell1.colSpan = 12;
            cell1.innerHTML = "Cluster";
            row.appendChild(cell1);
            tbody.appendChild(row);
            newtable.appendChild(row);
            clonedTable.appendChild(newtable);
            clonedTable.appendChild(clonedtable_cluster);
            var row = document.createElement("tr");
            var tbody = document.createElement("tbody");
            var newtable = document.createElement("table");
            row.setAttribute("style", "background-color: black;color: white; font-family:Calibri;");
            var cell1 = document.createElement("td");
            cell1.colSpan = 12;
            cell1.innerHTML = "SHG";
            row.appendChild(cell1);
            tbody.appendChild(row);
            newtable.appendChild(row);
            clonedTable.appendChild(newtable);
            clonedTable.appendChild(clonedtable_shg);
            var row = document.createElement("tr");
            var tbody = document.createElement("tbody");
            var newtable = document.createElement("table");
            row.setAttribute("style", "background-color: black;color: white; font-family:Calibri;");
            var cell1 = document.createElement("td");
            cell1.colSpan = 12;
            cell1.innerHTML = "Family";
            row.appendChild(cell1);
            tbody.appendChild(row);
            newtable.appendChild(row);
            clonedTable.appendChild(newtable);
            clonedTable.appendChild(clonedtable_family);
            var ctx = { worksheet: name || 'Worksheet', table: clonedTable.innerHTML }
            var link = document.createElement('a');
            link.download = filename;
            link.href = uri + base64(format(template, ctx));
            link.click();
        }
})();
var tableToExcel1 = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns=""><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name,filename) {
      if (!table.nodeType) table = document.getElementById(table)
              var newtable=document.createElement("table");
              var tbody =document.createElement("tbody");
              //  var row = document.createElement("tr");
              //  row.setAttribute("style", "background-color: black;color: white; font-family:'Source Sans Pro';");
                // 	var cell1 = document.createElement("td");
                // 	cell1.colSpan=7;
                // 	cell1.innerHTML ="Date as on : - <?php echo date('jS \ F Y'); ?>";
                // 	row.appendChild(cell1);
               //  	tbody.appendChild(row);
               //  	newtable.appendChild(tbody);
               var clonedTable=newtable.cloneNode(true);
               var clonedTable1=table.cloneNode(true);
              clonedTable.appendChild(clonedTable1);
      var ctx = {worksheet: name || 'Worksheet', table: clonedTable.innerHTML}
      //window.location.href = uri + base64(format(template, ctx))
       var link = document.createElement('a');
      link.download =filename;
      link.href = uri + base64(format(template, ctx));
      link.click();
       clonedTable.remove();
    }
  })();
