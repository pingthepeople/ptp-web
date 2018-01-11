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

const contains = (str, sub) => str.indexOf(sub) !== -1;
/// remove spaces from a string
const removeSpaces = (str) => str.replace(' ','');
/// determines whether this bill's display name ("SB 123") is contained 
/// in a list of possible bill names and/or if its number ("123") is 
/// contained in a list of possible bill numbers.
const containsBillName = (name, qNames, qNumbers) => {
    const lower = name.toLowerCase();   // "sb 123"
    const bName = removeSpaces(lower);  // "sb123"
    const bNum = bName.substring(2);    // "123"
    return  qNames.some(q => q === bName) 
        || qNumbers.some(q => q === bNum);
};

/// filter bills to those matching the search string.
const filterBills = (bills, query) => {
    const q = query.toLowerCase();
    // find parts of the query string matching a bill name ("sb 123", "hb1004") or number ("123", "1004")
    const l = q.match(/([hs][bcjr]\s*)?(\d*)/g).map(s=>removeSpaces(s));
    const qNames =   l.filter(s=>/^[sh]+/.test(s));  // those like "sb 123", "hb1004"
    const qNumbers = l.filter(s=>/^[0-9]+/.test(s)); // those like "123", "1004"
    const matchesName = (b) => containsBillName(b.DisplayName, qNames, qNumbers);
    const matchesSubjects = (b) => b.subjects.some(e=>contains(e.Name,q));
    const matchesCommittees = (b) => b.committees.some(e=>contains(e.Name,q));
    const matchesTitle = (b) => contains(b.Title,q);
    const matchesDescription = (b) => contains(b.Description,q);
    return bills.filter(b =>
        matchesName(b)
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
