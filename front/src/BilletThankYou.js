import { useContext, useEffect } from 'react';
import { useNavigate } from "react-router-dom";
import { BilletContext } from './BilletContext';
import './BilletThankYou.css';

function BilletThankYou() {
    const { billetLinkPayload } = useContext(BilletContext);
    const navigate = useNavigate();

    useEffect(() => {
        console.log(billetLinkPayload);  // Esta linha é apenas para debugging
    }, [billetLinkPayload]);

    const goHome = () => {
        navigate('/');
    }

    return (
        <div className="thankyou-container">
            <h2 className='h2-pix'>Obrigado pela preferência, e volte sempre!</h2>
            <h3>Seu Boleto</h3>
            {billetLinkPayload ? (
                <div className="billet-details">
                    <a href={billetLinkPayload} target="_blank" rel="noreferrer" className="billet-link-btn">Baixar boleto agora</a> 
                </div>
            ) : (
                <p>Carregando o boleto...</p>
            )}
            <button onClick={goHome} className="home-btn">Voltar para a página inicial</button>
        </div>
    );
}

export default BilletThankYou;

