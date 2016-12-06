$("#RefreshList").click(function(){		
		$.ajax({
				type: 'POST',
				url: 'site/ajax',					
				dataType: 'json',
                                contentType: "application/json; charset=utf-8",
				success: function(data) {					
			        var list = document.getElementById('DataList');		
					
					$(document.getElementById('DataList')).empty();
						
						for (var i = 0; i < data.length; i++) {
							var entry = document.createElement('li');
                                                        entry.appendChild(document.createTextNode(JSON.stringify(data[i])));
							list.appendChild(entry);
						}												
					}
		});
});

