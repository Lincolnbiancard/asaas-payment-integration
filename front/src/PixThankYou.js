import { useContext, useEffect, useState } from 'react';
import { useNavigate } from "react-router-dom";
import { PixContext } from './PixContext';
import './PixThankYou.css';

function PixThankYou() {
    const { pixPayload, pixImage } = useContext(PixContext);
    const [copySuccess, setCopySuccess] = useState('');
    const navigate = useNavigate();

    useEffect(() => {
        console.log(pixPayload, pixImage);  // Esta linha é apenas para debugging
    }, [pixPayload, pixImage]);

    const copyToClipboard = () => {
        navigator.clipboard.writeText(pixPayload);
        setCopySuccess('Copiado!');
    };

    const goHome = () => {
        navigate('/');
    }

    return (
        <div className="thankyou-container">
            <h2>Obrigado pela preferência, e volte sempre!</h2>
            <h3>Seu PIX</h3>
            {pixImage ? (
                <div className="pix-details">
                    <img src={`data:image/png;base64,${pixImage}`} alt="QR Code" className="pix-qrcode" />
                    <button onClick={copyToClipboard} className="pix-copy-btn">Copiar Código PIX</button> 
                    {copySuccess && <p style={{ color: 'green' }}>{copySuccess}</p>}
                </div>
            ) : (
                <p>Carregando imagem QR...</p>
            )}
            <button onClick={goHome} className="home-btn">Voltar para a página inicial</button>
        </div>
    );
}

export default PixThankYou;
