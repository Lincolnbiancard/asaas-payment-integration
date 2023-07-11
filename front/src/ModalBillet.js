import React, { useState } from "react";
import { useNavigate  } from "react-router-dom";
import { useContext } from 'react';
import { BilletContext } from "./BilletContext";

function ModalBillet({ isOpen, onClose, setShowNotification, setNotificationType, setNotificationMessage, value }) {
  const [name, setName] = useState("");
  const [cpfCnpj, setCpfCnpj] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const { setBilletLinkPayload } = useContext(BilletContext);
  const navigate = useNavigate();

  const handleConfirm = async (e) => {
    e.preventDefault();

    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        payment: {
          billingType: "BOLETO",
          value: value, // Substitua pelo valor real aqui
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
      const bankSlipUrl = data['data']['bankSlipUrl'];

      setBilletLinkPayload(bankSlipUrl);

      onClose();  // Fechar ModalConfirmData
      navigate("/thankyou-billet");
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

  return (
    <div>
      {isOpen && (
        <div className="credit-card-form">
          <button onClick={onClose} className="close-button">×</button>
          <h2>Digite seus dados para prosseguirmos com o pagamento</h2>
          <form onSubmit={handleConfirm}>
            <label htmlFor="name">
              Nome
              <input
                type="text"
                id="name"
                placeholder="Seu Nome"
                value={name}
                onChange={(e) => setName(e.target.value)}
                required
              />
            </label>
            <label htmlFor="cpfCnpj">
              CPF/CNPJ
              <input
                type="text"
                id="cpfCnpj"
                placeholder="Seu CPF ou CNPJ"
                value={cpfCnpj}
                onChange={(e) => setCpfCnpj(e.target.value)}
                required
              />
            </label>
            <label htmlFor="email">
              Email
              <input
                type="email"
                id="email"
                placeholder="seuemail@exemplo.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
            </label>
            <label htmlFor="phone">
              Telefone
              <input
                type="tel"
                id="phone"
                placeholder="(XX) XXXXX-XXXX"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
                required
              />
            </label>
            <button type="submit">Prosseguir</button>
          </form>
        </div>
      )}
    </div>
  );
}

export default ModalBillet;