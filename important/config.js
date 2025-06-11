async function loadConfig() {
    try {

        const protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';

        const hostname = window.location.hostname;

        const port = window.location.port ? ':' + window.location.port : '';  

        const siteUrl = protocol + hostname + port;

        const config = {
            siteUrl: siteUrl,  
            timezone: 'America/New_York',  
            database: {
                host: 'localhost',
                name: 'loogle_plus',
                user: 'root',
                password: 'nicknick'
            }
        };

        console.log("Site URL:", config.siteUrl);
        console.log("Timezone:", config.timezone);
        console.log("Database Host:", config.database.host);

        return config;
    } catch (error) {
        console.error("Error loading config:", error);
    }
}

loadConfig().then(config => {
    console.log("Loaded Site URL:", config.siteUrl);
    console.log("Loaded Timezone:", config.timezone);
});