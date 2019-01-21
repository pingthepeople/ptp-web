
const getQueryVariable = (key) => {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if(pair[0] === key) {
            return pair[1];
        }
	}
	return(false);
}

const updateQueryVariable = (key, value, url) => {
    if(window.history) {
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

        window.history.pushState({[key]: value}, '', url)
    }
}

export const pageGetter = () => {
    return parseInt(getQueryVariable('page') || 1);
}

export const pageSetter = (page) => {
    updateQueryVariable('page', page);
}

export const paginate = (array, page, pageLength) => {
    return array.slice(
        page*pageLength, 
        page*pageLength+pageLength);
};

export const truncate = (str, maxLen) => {
    if (str.length <= maxLen || maxLen === 0) return str;
    return str.substr(0, str.lastIndexOf(' ', maxLen));
};

export const pluralizeAuthor = n => (n === 1 ? "Author" : "Authors");
export const pluralizeCoauthor = n => (n === 1 ? "Coauthor" : "Coauthors");
export const pluralizeSponsor = n => (n === 1 ? "Sponsor" : "Sponsors");
export const pluralizeCosponsor = n => (n === 1 ? "Cosponsor" : "Cosponsors");
export const pluralizeSubjects = n => (n === 1 ? "Subject" : "Subjects");
export const pluralizeCommittees = n => (n === 1 ? "Committee" : "Committees");
