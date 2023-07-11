import React, { useState } from 'react';
import { BilletContext } from './BilletContext';

export function BilletProvider({ children }) {
    const [billetLinkPayload, setBilletLinkPayload] = useState(null);

    return (
        <BilletContext.Provider value={{ billetLinkPayload, setBilletLinkPayload }}>
            {children}
        </BilletContext.Provider>
    );
}
