modules.define('greeting', function(provide) {
	
	console.log(provide);
	
    provide({
        helloInLang: {
            en: 'Hello world!',
            es: '?Hola mundo!',
            ru: 'Привет, Мир!'
        },
        sayHello: function (lang) {
            return this.helloInLang[lang];
        }
    });
});