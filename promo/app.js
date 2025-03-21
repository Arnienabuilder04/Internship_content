const video1 = document.getElementById('video1');
const overlay = document.querySelector('.overlay');
const start = document.querySelector('.start');
const friendInputs = document.querySelectorAll(".friend-container input");
const successContainer = document.getElementById("successContainer");

document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector('.Form');

    let friendCount = 1;

    overlay.addEventListener('click', () => {
        video1.play();
        overlay.style.display = 'none';
    });

    video1.addEventListener('loadedmetadata', () => {
        const duration = video1.duration;
        const blurStartTime = duration - 2;

        video1.addEventListener('timeupdate', () => {
            if (video1.currentTime >= blurStartTime) {
                video1.classList.add('blur');
                form.classList.add('is-active');
            }
        });

        video1.addEventListener('ended', () => {
            form.classList.add('is-active');
        });
    });

    function revealNextFriend() {
        if (friendCount < friendInputs.length) {
            friendInputs[friendCount].classList.remove('hidden');
            friendCount++;
        }
        friendInputs[friendCount - 1].addEventListener('click', revealNextFriend);
    }
    friendInputs[friendCount - 1].addEventListener('click', revealNextFriend);

});

const form = document.querySelector('.Form');


async function postData(url = '', data = {}) {
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'text/plain'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

if ( form ) {

    form.addEventListener('submit', (e) => {
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

        postData('./admin/test_index.php', insertData)
            .then((data) => {
                console.log(data); // JSON data parsed by `data.json()` call
            });
            successContainer.style.display = 'grid';
            form.style.display = 'none';
        return false;
    });
}
