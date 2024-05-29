const express = require('express');
const axios = require('axios');
const crypto = require('crypto');
const sgMail = require('@sendgrid/mail');
require('dotenv').config();

const app = express();

const CLIENT_ID = process.env.CLIENT_ID;
const CLIENT_SECRET = process.env.CLIENT_SECRET;
const REDIRECT_URI = 'http://localhost:8000/google-auth/callback';
const SENDGRID_API_KEY = process.env.SENDGRID_API_KEY;

if (!SENDGRID_API_KEY.startsWith('SG.')) {
    console.error('API key does not start with "SG.".');
    process.exit(1);
}

sgMail.setApiKey(SENDGRID_API_KEY);

app.get('/google-auth', (req, res) => {
    const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${CLIENT_ID}&redirect_uri=${REDIRECT_URI}&response_type=code&scope=email%20profile%20openid`;
    res.redirect(authUrl);
});

app.get('/google-auth/callback', async (req, res) => {
    const { code } = req.query;

    try {
        const response = await axios.post('https://oauth2.googleapis.com/token', {
            code,
            client_id: CLIENT_ID,
            client_secret: CLIENT_SECRET,
            redirect_uri: REDIRECT_URI,
            grant_type: 'authorization_code',
        });

        const { access_token } = response.data;

        const userInfo = await axios.get(`https://www.googleapis.com/oauth2/v2/userinfo?access_token=${access_token}`);

        const user = userInfo.data;
        const verificationToken = crypto.randomBytes(32).toString('hex');

        // Aquí debes guardar el usuario y el token en la base de datos (no implementado en este ejemplo)

        const verificationUrl = `http://localhost:8000/verify-email?token=${verificationToken}`;
        const msg = {
            to: user.email,
            from: 'no-reply@tuapp.com',
            subject: 'Verifica tu correo electrónico',
            text: `Por favor, verifica tu correo electrónico haciendo clic en el siguiente enlace: ${verificationUrl}`,
            html: `<strong>Por favor, verifica tu correo electrónico haciendo clic en el siguiente enlace: <a href="${verificationUrl}">Verificar</a></strong>`,
        };
        await sgMail.send(msg);

        res.json({ message: 'Autenticación exitosa. Por favor, verifica tu correo electrónico.' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Error de autenticación' });
    }
});

app.get('/verify-email', async (req, res) => {
    const { token } = req.query;

    // Aquí debes buscar al usuario por el token en la base de datos y verificar su correo (no implementado en este ejemplo)

    res.send('Correo electrónico verificado correctamente.');
});

app.listen(8000, () => {
    console.log('Servidor iniciado en http://localhost:8000');
});
