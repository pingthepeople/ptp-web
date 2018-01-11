const getQueryVariable = (variable) => {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if(pair[0] == variable){return pair[1];}
	}
	return(false);
}

const updateQueryVariable = (key, value, url) => {
    if(window.history) {
        let oldValue = getQueryVariable(key)

        if (!url) url = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
            hash;

        if (re.test(url)) {
            if (typeof value !== 'undefined' && value !== null)
                url = url.replace(re, '$1' + key + "=" + value + '$2$3');
            else {
                hash = url.split('#');
                url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
            }
        }
        else {
            if (typeof value !== 'undefined' && value !== null) {
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                hash = url.split('#');
                url = hash[0] + separator + key + '=' + value;
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
            }
        }

        history.pushState({[key]: value}, '', url)
    }
}

const filterBills = (bills, query) => {
    let q = query.toLowerCase();
    var contains = (str, sub) => str.indexOf(sub) !== -1;
    var containsQuery = (str) => contains(str.toLowerCase(), query);
    var nameInQuery = (name) => {
        x = name.toLowerCase();
        return contains(query, x) 
        || contains(query, x.replace(' ',''));  
    };
    return bills.filter(b =>
        nameInQuery(b.DisplayName)
        || (b.subjects.some (e => containsQuery(e.Name)))
        || (b.committees.some (e => containsQuery(e.Name)))
        || containsQuery(b.Title)
        || containsQuery(b.Description));
}

export {
    getQueryVariable,
    updateQueryVariable,
    filterbills
}
