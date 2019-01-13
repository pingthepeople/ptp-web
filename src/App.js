import React, { Component } from 'react';
import { BrowserRouter as Router, Route } from "react-router-dom";
import './css/app.scss';
import Header from './components/Header';
import Footer from './components/Footer';
import Home from './GuestHomeView';
import AllLegislation from './AllLegislationView';
import About from './AboutView';

class App extends Component {
  render() {
    return (
      <Router>
        <div className="site__wrapper">
          <Header navList={[
            {text: "Home", url: "/", exact: true},
            {text: "All legislation", url: "/bills/"},
            {text: "About", url: "/about/"},
          ]}/>

          <div className="site__content content-wrapper">
              <div className="main">
                <Route path="/" exact component={Home} />
                <Route path="/bills/" component={AllLegislation} />
                <Route path="/about/" component={About} />
              </div>
          </div>
          
          <Footer />
        </div>
      </Router>
    );
  }
}

export default App;
