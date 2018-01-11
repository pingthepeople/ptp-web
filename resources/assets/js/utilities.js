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

const splitAndTrim = (str, delim) => str.split(delim).map(x => x.trim());
const contains = (str, sub) => str.indexOf(sub) !== -1;
const compress = (str) => str.replace(' ','');
const anyMatchesExactly = (cand, parts) => {
    c = cand.toLowerCase();
    return strs.some(p => c === p || compress(c) === p );
};

const filterBills = (bills, query) => {
    const q = query.toLowerCase();
    const parts = splitAndTrim(q, ',');
    const matchesDisplayName = (b) => anyMatchesExactly(b.DisplayName,parts);
    const matchesSubjects = (b) => b.subjects.some(e=>contains(e.name,q));
    const matchesCommittees = (b) => b.committees.some(e=>contains(e.name,q));
    const matchesTitle = (b) => contains(b.Title,q);
    const matchesDescription = (b) => contains(b.Description,q);
    return bills.filter(b =>
        matchesDisplayName(b)
        || matchesSubjects(b)
        || matchesCommittees(b)
        || matchesTitle(b)
        || matchesDescription(b));
}

export {
    getQueryVariable,
    updateQueryVariable,
    filterBills
}
