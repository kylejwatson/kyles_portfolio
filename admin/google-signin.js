/**
 * Created by kyle on 05/11/16.
 */
function onSignIn(googleUser) {
    alert("test");
    var id_token = googleUser.getAuthResponse().id_token;
    var url = 'index.php?id=' + id_token;
    window.location.href = url;
}