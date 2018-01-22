$.ajax({
    url: settings.root + 'wt-pars-theme/v2/testfiles/',
    method: 'GET',
    dataType: 'blob',
    beforeSend: function(xhr){
        xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
    },
    success: function (data) {
        console.log(data);
    },
    error: function (xhr, status, error) {
        console.info(xhr.responseText);
    },
}); 