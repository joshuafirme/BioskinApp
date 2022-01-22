document.addEventListener('DOMContentLoaded', function() {

    getNotification();

    setInterval (async function() {
        await getNotification();
    },5000);

    $(document).on('click', '#notif-bell', function () {
        if ($(this).attr('aria-expanded') == "true") { 
            localStorage.setItem('total_notif', 0);
            localStorage.setItem('notif_bell_is_opened', 1);
        }
        localStorage.setItem('notif_bell_is_opened', 0);
    })

    function getTotalNotif(notif) {
        return  notif.processing_count + notif.otw_count +notif.to_receive_count + notif.order_receive_count + notif.completed_count + notif.cancelled_count;
    }

    async function getNotification () {
        $.ajax({
            url: '/notification',
            type: 'GET',
            success:function(data){
              
                data = JSON.parse(data);
                let notif = data.notif_counts;
          
                let total_notif = 0

           
                $('#total-notif').text(localStorage.getItem('total_notif', total_notif));

                if (notif.processing_count || notif.otw_count ||notif.to_receive_count || notif.order_receive_count || notif.completed_count || notif.cancelled_count) {
                    total_notif = getTotalNotif(notif);
                    total_notif = parseInt(total_notif) + parseInt(localStorage.getItem('total_notif'));
                    localStorage.setItem('total_notif', total_notif);
                }
                if (notif.processing_count > 0) {
                    $.toast({
                        text: notif.processing_count +" new <b>processing</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                if (notif.otw_count > 0) {
                    $.toast({
                        text: notif.otw_count +" new <b>on the way</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                if (notif.to_receive_count > 0) {
                    $.toast({
                        text: notif.to_receive_count +" new <b>to receive</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                if (notif.order_receive_count > 0) {
                    $.toast({
                        text: notif.order_receive_count +" new <b>to receive</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                if (notif.completed_count > 0) {
                    $.toast({
                        text: notif.completed_count +" new <b>completed</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                if (notif.cancelled_count > 0) {
                    $.toast({
                        text: notif.cancelled_count +" new <b>cancelled</b> orders",
                        showHideTransition: 'plain',
                        hideAfter: 8000, 
                    });
                }
                let divider = `<div class="dropdown-divider"></div>`;
                let notif_content = `<span class="dropdown-item dropdown-header">Notification</span>`;
                
                if (data.notif_content.processing) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.processing}</a>`+divider;
                }
                if (data.notif_content.otw) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.otw}</a>`+divider;
                }
                if (data.notif_content.to_receive) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.to_receive}</a>`+divider;
                }
                if (data.notif_content.order_received) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.order_received}</a>`+divider;
                }
                if (data.notif_content.completed) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.completed}</a>`+divider;
                }
                if (data.notif_content.cancelled) {
                  notif_content += `<a href="/manage-order" class="dropdown-item">${data.notif_content.cancelled}</a>`+divider;
                }
                
                

                $('#notification-container').html(notif_content)
            }
        });
    }

  //  setCookie('notif_bell_is_opened', 1, '')

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      
      function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
      
      function checkCookie() {
        let user = getCookie("username");
        if (user != "") {
          alert("Welcome again " + user);
        } else {
          user = prompt("Please enter your name:", "");
          if (user != "" && user != null) {
            setCookie("username", user, 365);
          }
        }
      }
});