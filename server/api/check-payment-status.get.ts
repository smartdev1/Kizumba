/**
 * server/api/check-payment-status.get.ts
 * 
 * Vérifie le statut d'une commande après paiement PayDunya
 * Appelé depuis checkout.vue après redirection
 */

export default defineEventHandler(async (event) => {
    const query = getQuery(event)
    const tx_ref = query.tx_ref
    
    if (!tx_ref) {
        return { 
            success: false, 
            status: 'error', 
            message: 'tx_ref manquant' 
        }
    }
    
    const config = useRuntimeConfig()
    const wpApiUrl = config.public.wpApiUrl
    
    try {
        // Appel à l'API WordPress pour récupérer le statut de la commande
        const response = await $fetch(`${wpApiUrl}/eventflow/v1/payments/paydunya/status/${tx_ref}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        
        return response
        
    } catch (error: any) {
        console.error('Erreur vérification statut:', error)
        
        return { 
            success: false, 
            status: 'error', 
            message: error?.message || 'Erreur de vérification du paiement' 
        }
    }
})