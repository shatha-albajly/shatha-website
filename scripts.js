async function signup() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    console.log(username, email, phone, password, confirmPassword)
    if (password !== confirmPassword) {
        alert('password do not match');
    }

    if (!username || !email || !phone || !password || !confirmPassword) {
        alert('fill in all the fields');
    }

    else {

        const response = await fetch('index.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'signup',
                username: username,
                email: email,
                phone: phone,
                password: password
            })
        });
        console.log(response)

        const result = await response.json();
        console.log(response)
        alert(result.message);
    }
}

async function login() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    console.log(email, password)

    const response = await fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'login',
            email: email,
            password: password
        })
    });

    const result = await response.json();
    alert(result.message);
}
async function resetPassword() {
    console.log('gg')

    const email = document.getElementById('email').value;
    console.log(email)

    const response = await fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'resetPassword',
            email: email,
        })
    });

    const result = await response.json();
    alert(result.message);
}


async function changePassword() {

    const password = document.getElementById('new-password').value;

    const response = await fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'changePassword',
            password: password,
        })
    });

    const result = await response.json();
    alert(result.message);
}