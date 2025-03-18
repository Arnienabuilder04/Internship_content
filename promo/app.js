async function postData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

$intro = document.querySelector('.js-intro');
$start = $intro.querySelector('.js-start');
$video = $intro.querySelector('.js-video');
$source = $intro.querySelector('.js-videoSource');
$form = document.querySelector('.js-form');

let intro_source;

if( window.innerHeight > window.innerWidth ){
    intro_source = 'assets/INVITE_9x16_v3.mp4';
} else {
    intro_source = 'assets/INVITE_16x9_v3.mp4';
}

var res = document.createElement("link");
res.rel = "prefetch";
//res.as = "video";
res.href = intro_source;
document.head.appendChild(res);

if ( $intro ) {

    $start.addEventListener('click', () => {
        $source.setAttribute('src', intro_source);
        $intro.classList.add('is-playing');
        $video.addEventListener('canplaythrough', (event) => {
            $video.play();
        });
        $video.load();
    });

    $video.addEventListener('ended', () => {
        $intro.classList.add('is-played');
        $form.classList.add('is-active');
    });
}

if ( $form ) {

    $form.addEventListener('submit', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const formData = new FormData(e.target),
              name = formData.get('name'),
              email = formData.get('email'),
              phone = formData.get('phone'),
              friend1_name = formData.get('friend1_name'),
              friend2_name = formData.get('friend2_name'),
              friend3_name = formData.get('friend3_name');
        
        const insertData = {
            name: name,
            email: email,
            phone: phone,
            friend1_name: friend1_name,
            friend2_name: friend2_name,
            friend3_name: friend3_name
        };

        postData('admin/index.php', insertData)
            .then((data) => {
                //console.log(data); // JSON data parsed by `data.json()` call
            });

        $form.classList.add('is-sent');

        return false;
    });
}
