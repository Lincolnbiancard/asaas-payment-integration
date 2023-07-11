import React, { useState } from 'react';
import { PixContext } from './PixContext';

export function PixProvider({ children }) {
    const [pixPayload, setPixPayload] = useState(null);
    const [pixImage, setPixImage] = useState(null);

    return (
        <PixContext.Provider value={{ pixPayload, setPixPayload, pixImage, setPixImage }}>
            {children}
        </PixContext.Provider>
    );
}
