function slideToggle(t,e,o){0===t.clientHeight?j(t,e,o,!0):j(t,e,o)}function slideUp(t,e,o){j(t,e,o)}function slideDown(t,e,o){j(t,e,o,!0)}function j(t,e,o,i){void 0===e&&(e=400),void 0===i&&(i=!1),t.style.overflow="hidden",i&&(t.style.display="block");var p,l=window.getComputedStyle(t),n=parseFloat(l.getPropertyValue("height")),a=parseFloat(l.getPropertyValue("padding-top")),s=parseFloat(l.getPropertyValue("padding-bottom")),r=parseFloat(l.getPropertyValue("margin-top")),d=parseFloat(l.getPropertyValue("margin-bottom")),g=n/e,y=a/e,m=s/e,u=r/e,h=d/e;window.requestAnimationFrame(function l(x){void 0===p&&(p=x);var f=x-p;i?(t.style.height=g*f+"px",t.style.paddingTop=y*f+"px",t.style.paddingBottom=m*f+"px",t.style.marginTop=u*f+"px",t.style.marginBottom=h*f+"px"):(t.style.height=n-g*f+"px",t.style.paddingTop=a-y*f+"px",t.style.paddingBottom=s-m*f+"px",t.style.marginTop=r-u*f+"px",t.style.marginBottom=d-h*f+"px"),f>=e?(t.style.height="",t.style.paddingTop="",t.style.paddingBottom="",t.style.marginTop="",t.style.marginBottom="",t.style.overflow="",i||(t.style.display="none"),"function"==typeof o&&o()):window.requestAnimationFrame(l)})}

let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for(var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
	sidebarItems[i].querySelector('.sidebar-link').addEventListener('click', function(e) {
        e.preventDefault();

        let submenu = sidebarItem.querySelector('.submenu');
        if( submenu.classList.contains('active') ) submenu.style.display = "block"

        if( submenu.style.display == "none" ) submenu.classList.add('active')
        else submenu.classList.remove('active')
        slideToggle(submenu, 300)
    })
}

window.addEventListener('DOMContentLoaded', (event) => {
    var w = window.innerWidth;
    if(w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    }
});
window.addEventListener('resize', (event) => {
    var w = window.innerWidth;
    if(w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    }else{
        document.getElementById('sidebar').classList.add('active');
    }
});

document.querySelector('.burger-btn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');
})
document.querySelector('.sidebar-hide').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');

})

window.onload = function (){
    let path = window.location.pathname;
    let sidebarItems = document.querySelectorAll('.sidebar-item');
    for(var i = 0; i < sidebarItems.length; i++) {
        if(path.includes($(sidebarItems[i]).attr('target'))){
            $(sidebarItems[i]).addClass('active')
        }
        else{
            $(sidebarItems[i]).removeClass('active')
        }
    }
}

/////////////////////////////////////////custom/////////////////////////////////////////////////







function createToast(content,type,duration = 3000){
    Toastify({
        text: content,
        duration: duration,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true, // Prevents dismissing of toast on hover
        className:type
    }).showToast();
}

//
// preview images
function fileToDataURL(file) {
    var reader = new FileReader()
    return new Promise(function (resolve, reject) {
        reader.onload = function (event) {
            resolve(event.target.result)
        }
        reader.readAsDataURL(file)
    })
}

function readAsDataURL(target) {
    var filesArray = Array.prototype.slice.call(target.files)
    return Promise.all(filesArray.map(fileToDataURL))
}

function getImagesUrl(){
    return Array.from($('.tab-pane')).map(tab => {
        let input = tab.querySelector('input[name="images"]')
        if(input){
            const size = Array.from(input.files).reduce((size,item) => size + item.size,0) / 1024/1024; // megabytes
            if(size > 40){
                alert('tổng kích thước tối đa phải nhỏ hơn 40mb')
            }
            else{
                if(size<=0){
                    return Promise.resolve({
                        tab:tab.getAttribute('id'),
                        urls:[{name:''}]
                    });
                }
                else{
                    return uploadImages(input.files,tab);
                }
            }
        }
    })
}



// upload images
function uploadImages(files,tab,route){
    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
        formData.append('img[]', files[i], files[i].name);
    }
    formData.append('tab',tab.getAttribute('id'))
    formData.append('_token',$('#_token').val())
    return $.ajax({
        url : '/images/upload',
        type : 'POST',
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'json',
    });
}
