import React, { useState, useEffect } from 'react';
import ModalPix from './ModalPix';
import ModalBillet from './ModalBillet';
import { useNavigate } from 'react-router-dom';

function PaymentPage() {
    const [selectedValue, setSelectedValue] = useState(null);
    const [games, setGames] = useState([]);
    const [showCreditCardForm, setShowCreditCardForm] = useState(false);
    const [showPaymentModal, setShowPaymentModal] = useState(false);
    const [holderName, setHolderName] = useState("");
    const [cardNumber, setCardNumber] = useState("");
    const [expiryMonth, setExpiryMonth] = useState("");
    const [expiryYear, setExpiryYear] = useState("");
    const [ccv, setCcv] = useState("");
    const [email, setEmail] = useState("");
    const [cpfCnpj, setCpfCnpj] = useState("");
    const [phone, setPhone] = useState("");
    const [name, setName] = useState("");
    const [postalCode, setPostalCode] = useState("");
    const [addressNumber, setAddressNumber] = useState("");
    const [showNotification, setShowNotification] = useState(false);
    const [notificationType, setNotificationType] = useState("");
    const [notificationMessage, setNotificationMessage] = useState("");
    const [showModalPix, setShowModalPix] = useState(false);
    const [showModalBillet, setShowModalBillet] = useState(false);
    const navigate = useNavigate();

    const clearForm = () => {
        setHolderName("");
        setCardNumber("");
        setExpiryMonth("");
        setExpiryYear("");
        setCcv("");
        setName("");
        setEmail("");
        setPhone("");
        setCpfCnpj("");
        setPostalCode("");
        setAddressNumber("");
    }

    const handleFormSubmit = async (e) => {
        e.preventDefault();
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                payment: {
                    billingType: "CREDIT_CARD",
                    value: selectedValue?.price,
                    description: "Pedido 056984", // Substitua pela descrição real aqui
                    externalReference: "056984", // Substitua pela referência externa real aqui
                    creditCard: {
                        holderName: holderName,
                        number: cardNumber,
                        expiryMonth: expiryMonth,
                        expiryYear: expiryYear,
                        ccv: ccv
                    },
                    creditCardHolderInfo: {
                        name: holderName,
                        email: email,
                        cpfCnpj: cpfCnpj,
                        phone: phone,
                        postalCode: postalCode,
                        addressNumber: "277"
                    },
                    creditCardToken: "76496073-536f-4835-80db-c45d00f33695" // habilitar validação de erros do lado do asaas
                },
                customer: {
                    name: name,
                    email: email,
                    phone: phone,
                    cpfCnpj: cpfCnpj
                }
            })
        };

        try {
            const response = await fetch('http://127.0.0.1/api/payments', requestOptions);

            if (!response.ok) {
                throw response;
            }

            const data = await response.json();
            setShowCreditCardForm(false);
            clearForm();
            const transactionData = {
                name: selectedValue?.name,
                amount: selectedValue?.price
            };
            
            navigate('/thank-you-credit-card', { state: { transactionData } });
        } catch (error) {
            const errorData = await error.json(); // Recebe os dados do erro
            const errorMessages = errorData.errors; // Extrai as mensagens de erro

            let errorMessage = '';
            if (errorMessages && errorMessages.length > 0) {
                errorMessage = errorMessages.join('<br/>'); // Junta todas as mensagens de erro com um <br/>
            }

            setShowNotification(true);
            setNotificationType('error');
            setNotificationMessage(errorMessage);
        }

    };

    const openModalConfirmData = () => {
        setShowPaymentModal(false);
        setShowModalPix(true);
    }

    const openModalConfirmDataBillet = () => {
        setShowPaymentModal(false);
        setShowModalBillet(true);
    }

    useEffect(() => {
        fetch("https://api.rawg.io/api/games?key=c06a19e56ab64265b3af291d20be9561")
            .then(response => response.json())
            .then(data => {
                const gamesWithPrices = data.results.map(game => ({
                    ...game,
                    price: Math.floor(Math.random() * 300) + 0.99, // Adiciona preço aleatório entre $0.99 e $299.99
                }));
                setGames(gamesWithPrices);
            })
            .catch(error => {
                setShowNotification(true);
                setNotificationType('error');
                setNotificationMessage("Erro ao buscar dados de jogos: " + error);
            });
    }, []);

    return (

        <div className="payment-page">
            {showNotification &&
                <div className={`notification ${notificationType}`}>
                    <div className={`notification ${notificationType}`}>
                        <button className="notification-close-btn" onClick={() => setShowNotification(false)}>×</button>
                        <div dangerouslySetInnerHTML={{ __html: notificationMessage }} />
                    </div>

                </div>
            }
            {games.map(game => (
                <div
                    key={game.id}
                    className="payment-card"
                    style={{ background: `url(${game.background_image}) no-repeat center/cover` }}
                    onClick={() => {
                        setSelectedValue(game);
                        setShowPaymentModal(true);
                    }}
                >
                    <div className="payment-card-info">
                        <div className="price-tag">R${game.price}</div>
                        <p>{game.name}</p>
                    </div>
                </div>
            ))}

            <ModalPix
                isOpen={showModalPix}
                onClose={() => setShowModalPix(false)}
                setShowNotification={setShowNotification}
                setNotificationType={setNotificationType}
                setNotificationMessage={setNotificationMessage}
                value={selectedValue?.price}
            />

            <ModalBillet
                isOpen={showModalBillet}
                onClose={() => setShowModalBillet(false)}
                setShowNotification={setShowNotification}
                setNotificationType={setNotificationType}
                setNotificationMessage={setNotificationMessage}
                value={selectedValue?.price}
            />

            {showPaymentModal &&
                <div className="modal-overlay">
                    <div className="modal">
                        <button onClick={() => setShowPaymentModal(false)} className="close-button-credit">×</button>
                        <h2>Você selecionou {selectedValue?.name}, no valor de R${selectedValue?.price} </h2>
                        <h2>Como deseja pagar?</h2>
                        <div className="payment-options">
                            <button className="pix-button" onClick={() => openModalConfirmData()}>Pix</button>
                            <button onClick={() => {
                                setShowPaymentModal(false);
                                setShowCreditCardForm(true);
                            }}>Cartão de Crédito</button>
                            <button className="pix-button" onClick={() => openModalConfirmDataBillet()}>Boleto</button>
                        </div>
                    </div>
                </div>
            }

            {showCreditCardForm &&
                <div className="credit-card-form">
                    <button onClick={() => setShowCreditCardForm(false)} className="close-button">×</button>
                    <h2>Pagamento com Cartão de Crédito</h2>
                    <form onSubmit={handleFormSubmit}>
                        <h3>Informações do Titular do Cartão</h3>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="cardNumber">
                                    Número do Cartão
                                    <input type="text" id="cardNumber" placeholder="1234 5678 9101 1121" value={cardNumber} onChange={(e) => setCardNumber(e.target.value)} required />
                                </label>

                            </div>
                            <div className="form-column">
                                <label htmlFor="ccv">
                                    Código de Segurança
                                    <input type="text" id="ccv" placeholder="123" value={ccv} onChange={(e) => setCcv(e.target.value)} required />
                                </label>
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="expiryMonth">
                                    Mês de Expiração
                                    <input type="text" id="expiryMonth" placeholder="MM" value={expiryMonth} onChange={(e) => setExpiryMonth(e.target.value)} required />
                                </label>
                            </div>
                            <div className="form-column">
                                <label htmlFor="expiryYear">
                                    Ano de Expiração
                                    <input type="text" id="expiryYear" placeholder="AAAA" value={expiryYear} onChange={(e) => setExpiryYear(e.target.value)} required />
                                </label>
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="holderName">
                                    Nome do Titular
                                    <input type="text" id="holderName" placeholder="Nome do titular" value={holderName} onChange={(e) => setHolderName(e.target.value)} required />
                                </label>
                            </div>
                        </div>
                        <h3>Informações do Cliente</h3>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="name">
                                    Nome
                                    <input type="text" id="name" placeholder="Seu Nome" value={name} onChange={(e) => setName(e.target.value)} required />
                                </label>
                            </div>
                            <div className="form-column">
                                <label htmlFor="email">
                                    Email
                                    <input type="email" id="email" placeholder="seuemail@exemplo.com" value={email} onChange={(e) => setEmail(e.target.value)} required />
                                </label>
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="phone">
                                    Telefone
                                    <input type="tel" id="phone" placeholder="(XX) XXXXX-XXXX" value={phone} onChange={(e) => setPhone(e.target.value)} required />
                                </label>
                            </div>
                            <div className="form-column">
                                <label htmlFor="cpfCnpj">
                                    CPF/CNPJ
                                    <input type="text" id="cpfCnpj" placeholder="Seu CPF ou CNPJ" value={cpfCnpj} onChange={(e) => setCpfCnpj(e.target.value)} required />
                                </label>
                            </div>
                        </div>
                        <div className="form-row">
                            <div className="form-column">
                                <label htmlFor="postalCode">
                                    CEP
                                    <input type="text" id="postalCode" placeholder="XXXXX-XXX" value={postalCode} onChange={(e) => setPostalCode(e.target.value)} required />
                                </label>
                            </div>
                            <div className="form-column">
                                <label htmlFor="addressNumber">
                                    Número da Residência
                                    <input type="text" id="addressNumber" placeholder="222" value={addressNumber} onChange={(e) => setAddressNumber(e.target.value)} required />
                                </label>
                            </div>
                        </div>

                        <button type="submit">Pagar</button>
                    </form>
                </div>
            }

        </div>
    );
}

export default PaymentPage;
