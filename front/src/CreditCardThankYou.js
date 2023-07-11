import React from 'react';
import { useLocation } from 'react-router-dom';
import './CreditCardThankYou.css';
import { useNavigate } from "react-router-dom";


function CreditCardThankYou({ isOpen, onClose }) {
    const location = useLocation();
    const transactionData = location.state?.transactionData;
    const navigate = useNavigate();

    const goHome = () => {
        navigate('/');
    }

    return (
        <div className="modal-overlay">
            <div className="modal-credit-card">
                <button onClick={onClose} className="close-button">×</button>
                <h2>Obrigado por sua compra!</h2>
                <p>Você comprou o jogo {transactionData.name} com seu cartão de crédito.</p>
                <p>O valor da compra foi de R${transactionData.amount}.</p>
                <p>Agradecemos por escolher nossa loja e esperamos que você se divirta com seu novo jogo!</p>
                <button onClick={goHome} className="home-btn">Voltar para a página inicial</button>
            </div>
        </div>
    );
}

export default CreditCardThankYou;
