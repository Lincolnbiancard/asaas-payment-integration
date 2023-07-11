import './App.css';
import Payment from './Payment';
import { BrowserRouter as Router, Switch, Route, Routes } from "react-router-dom";
import PixThankYou from './PixThankYou';
import BilletThankYou from './BilletThankYou';
import { PixProvider } from './PixProvider';
import { BilletProvider } from './BilletProvider';
import CreditCardThankYou from './CreditCardThankYou';

function App() {
  return (
    <Router>
      <PixProvider>
        <BilletProvider>
          <Routes>
            <Route path="/thankyou" element={<PixThankYou />} />
            <Route path="/thankyou-billet" element={<BilletThankYou />} />
            <Route path="/thank-you-credit-card" element={<CreditCardThankYou />} />
            <Route path="/" element={<Payment />} />
          </Routes>
        </BilletProvider>
      </PixProvider>
    </Router>
  );
}

export default App;
