import React from 'react';
import Logo from '../assets/logo.png';
import { NavLink as Link } from 'react-router-dom';


const NavList = ({navList}) => (
    <ul className="nav-list">
        {navList.map((item, i) => (
            <li className="nav-item" key={i}>
                <Link 
                    to={item.url || '#0'} 
                    exact={item.exact || false}
                    activeClassName="is-active">
                    {item.text}
                </Link>
            </li>
        ))}
    </ul>
)

const Header = ({navList, showNav}) => (
    <header className="header" role="banner">
        <div className="content-wrapper">
            <div className="header__inner">
                <div className="header__primary">
                    <a href="{{url('/')}}" className="header__logo">
                        <span className="header__logo-graphic">
                            <img src={Logo} alt=""/>
                        </span>
                        <span className="header__logo-words">Ping The People</span>
                    </a>
                </div>
                <div className="header__secondary">
                    <nav className="main-nav">
                        <NavList navList={navList} />
                    </nav>
                </div>
                <button className="mobile-nav-trigger" click="showNav=!showNav">Menu</button>  
            </div>
        </div>
        {showNav &&
            <nav className="mobile-nav">
                <NavList navList={navList} />
            </nav>
        }
    </header>
);

export default Header;
