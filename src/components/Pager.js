import React from 'react';

const Pager = ({pageGetter, pageSetter, nItems, pageLength}) => {
    const nPages = Math.ceil((nItems || 0) / pageLength);
    const pages = [...Array(nPages).keys()].map(n => parseInt(n)+1);
    const prevPageNumber = Math.max(pageGetter()-1, 1);
    const nextPageNumber = Math.min(pageGetter()+1, nPages);
    const currentPage = pageGetter();
    const PrevLink = () => (
        <li className="pager__item">
            <a 
                className="pager__link" 
                href={`?page=${prevPageNumber}`}
                >
                Previous
            </a>
        </li>
    );
    const NextLink = () => (
        <li className="pager__item">
            <a 
                className="pager__link" 
                href={`?page=${nextPageNumber}`}
                >
                Next
            </a>
        </li>
    );
    return (
        <>
            {nPages > 1 && 
            <>
                <ul className="pager hide-sm-down">
                    <PrevLink/>
                    {pages.map((page, i) => {
                        const isActive = page === currentPage ? 'is-active': '';
                        return (
                        <li key={i} className="pager__item">
                            <a 
                                className={`pager__link ${isActive}`} 
                                href={`?page=${page}`}>
                                {page}
                            </a>
                        </li>
                        )
                    })}
                    <NextLink/>
                </ul>
                <div className="pager pager--mobile">
                    <label className="pager__select-label" htmlFor="page-select">
                        Jump to page<br/>
                        <select
                            id="page-select"
                            className="pager__select"
                            change="pageTo(selected)"
                            v-modelnumber="selected">
                            {pages.map((page, i) => (
                                <option key={i}>{page}</option>
                            ))}
                        </select>
                    </label>
                    
                    <PrevLink/>
                    <NextLink/>
                </div>
            </>
            }
        </>
    );
};

export default Pager;