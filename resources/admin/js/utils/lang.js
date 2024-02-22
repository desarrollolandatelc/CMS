const translations = {
    es: {
        name: 'Nombre',
        email: 'Correo electrónico',
        password: 'Contraseña',
        confirm_password: 'Confirmar contraseña',
        remember_me: 'Recordar',
        login: 'Iniciar sesión',
        forgot_password: '¿Olvidaste tu contraseña?',
        status: 'Estado',
        description: 'Descripción',
        actions: 'Acciones',
        created_at: 'Creado',
        updated_at: 'Actualizado',
        created_by: 'Creado por',
        updated_by: 'Actualizado por',
        client_name: 'Cliente',
        user_name: 'Usuario'
    },
    en: {
        name: 'English'
    }
}

export const trans = (key, lang = 'es') => {
    return translations[lang] && translations[lang][key] ? translations[lang][key] : key
}