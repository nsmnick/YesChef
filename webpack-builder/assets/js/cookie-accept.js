;(function() {

	var CookieAccept = function()
	{
		this.default_options = {
			class_notice: 'cookie-accept'
			, class_allow: 'cookie-accept__allow'
			, class_deny: 'cookie-accept__deny'
			, cookie: {
				name: 'accept_cookies'
				, expiry_days: 365
				, domain: ''
				, path: '/'
			}
			, attr_name: 'cookie-accept'
			, showNotice: function(notice, options) {
				notice.classList.add(options.class_notice+'--show');
			}
			, hideNotice: function(notice, options) {
				notice.classList.remove(options.class_notice+'--show');
			}
		};

		this.status = {
			allow: 'allow'
			, deny: 'deny'
		};

		this.init.apply(this, arguments);
	};

	CookieAccept.prototype.init = function(options)
	{
		var status = '';

		this.deepExtend(this.options = {}, this.default_options);

		if (this.isPlainObject(options))
		{
			this.deepExtend(this.options, options);
		}

		status = this.checkCookieStatus();

		if (status === undefined)
		{
			this.el_notice = document.getElementsByClassName(this.options.class_notice)[0];

			if (this.el_notice !== undefined)
			{
				this.configureEvents();
				this.showNotice();
			}
			else
			{
				console.log('Can\'t find cookie notice!');
			}
		}
		else if (status === this.status.allow)
		{
			this.enableCookies();
		}
	};

	CookieAccept.prototype.configureEvents = function()
	{
		var self = this;
		var el_allow_button = document.getElementsByClassName(this.options.class_allow)[0];
		var el_deny_button = document.getElementsByClassName(this.options.class_deny)[0];

		if (el_allow_button !== undefined)
		{
			el_allow_button.addEventListener('click', function(e) {
				e.preventDefault();

				self.allowCookies();
			}, false);
		}
		else
		{
			console.log('Allow button not found!');
		}

		if (el_deny_button !== undefined)
		{
			el_deny_button.addEventListener('click', function(e) {
				e.preventDefault();

				self.denyCookies();
			}, false);
		}
		else
		{
			console.log('Deny button not found!');
		}
	};

	CookieAccept.prototype.checkCookieStatus = function()
	{
		return this.getCookie(this.options.cookie.name);
	};

	CookieAccept.prototype.allowCookies = function()
	{
		this.setCookie(
			this.options.cookie.name
			, this.status.allow
			, this.options.cookie.expiry_days
			, this.options.cookie.domain
			, this.options.cookie.path
		);

		this.hideNotice();
		this.enableCookies();
	};

	CookieAccept.prototype.denyCookies = function()
	{
		// Deny cookies only last for session.
		this.setCookie(
			this.options.cookie.name
			, this.status.deny
			, false
			, this.options.cookie.domain
			, this.options.cookie.path
		);

		this.hideNotice();
	};

	CookieAccept.prototype.showNotice = function()
	{
		this.options.showNotice(this.el_notice, this.options);
	};

	CookieAccept.prototype.hideNotice = function()
	{
		this.options.hideNotice(this.el_notice, this.options);
	};

	CookieAccept.prototype.deepExtend = function(target, source) {
		for (var prop in source)
		{
			if (source.hasOwnProperty(prop))
			{
				if (prop in target && this.isPlainObject(target[prop]) && this.isPlainObject(source[prop]))
				{
					this.deepExtend(target[prop], source[prop]);
				}
				else
				{
					target[prop] = source[prop];
				}
			}
		}
		return target;
	};

	CookieAccept.prototype.isPlainObject = function(obj)
	{
		return typeof obj === 'object' && obj !== null && obj.constructor == Object;
	};

	CookieAccept.prototype.getCookie = function(name)
	{
		var value = '; ' + document.cookie;
		var parts = value.split('; ' + name + '=');
		return parts.length != 2 ? undefined : parts.pop().split(';').shift();
	};

	CookieAccept.prototype.setCookie = function(name, value, expiry_days, domain, path)
	{
		var cookie = [
			name + '=' + value
			, 'path=' + (path || '/')
		];

		if (this.isInteger(expiry_days) && expiry_days !== 0) {
			var expiry_date = new Date();
			expiry_date.setDate(expiry_date.getDate() + (expiry_days || 365));
			expiry_date = expiry_date.toUTCString();
		}
		else
		{
			expiry_date = 0;
		}

		cookie.push('expires=' + expiry_date);

		if (domain) {
			cookie.push('domain=' + domain);
		}

		document.cookie = cookie.join(';');
	}

	CookieAccept.prototype.enableCookies = function()
	{
		this.enableScripts();
		
	};

	CookieAccept.prototype.enableScripts = function()
	{
		var self = this;
		var scripts = document.querySelectorAll('script[type="text/plain"]['+this.options.attr_name+']');

		for (var i = 0; i < scripts.length; i++) {
		//scripts.forEach(function(el_script) {
			var el_script= scripts[i];

			var src_path = el_script.getAttribute('src');
			var el_new_src = document.createElement('script');
			el_new_src.setAttribute('type', 'text/javascript');

			if (src_path !== null && src_path !== '')
			{
				el_new_src.setAttribute('src', src_path);
				self.insertAfter(el_new_src, el_script);
			}
			else
			{
				el_new_src.innerHTML = el_script.innerHTML;
				self.insertAfter(el_new_src, el_script);
			};

			el_script.parentNode.removeChild(el_script);
		}
		//});
	};

	CookieAccept.prototype.insertAfter = function(el, referenceNode)
	{
		referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
	}

	CookieAccept.prototype.isInteger = Number.isInteger || function(value) {
		return typeof value === 'number'
			&& isFinite(value)
			&& Math.floor(value) === value;
	};

	window.CookieAccept = CookieAccept;

})();