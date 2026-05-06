<?php

namespace App\Livewire;

use App\Models\Medicament;
use App\Models\Lot;
use App\Models\CommandeFournisseur;
use App\Models\Fournisseur;
use App\Models\LigneCommande;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StockManager extends Component
{
    public $activeTab = 'inventory';
    public $search = '';
    public $lowStockMedicaments = [];
    public $selectedMedicaments = [];
    public $fournisseur_id = null;
    public $fournisseurs = [];

    public function mount()
    {
        $this->fournisseurs = Fournisseur::all();
        $this->loadLowStockMedicaments();
    }

    public function loadLowStockMedicaments()
    {
        $this->lowStockMedicaments = Medicament::withSum('lots', 'quantite')
            ->having('lots_sum_quantite', '<', 10)
            ->orHavingRaw('lots_sum_quantite IS NULL')
            ->get();
    }

    public function updatedSearch()
    {
        // Recherche mise à jour automatiquement via Livewire
    }

    public function addToOrder($medicamentId)
    {
        if (!isset($this->selectedMedicaments[$medicamentId])) {
            $medicament = Medicament::find($medicamentId);
            if ($medicament) {
                $this->selectedMedicaments[$medicamentId] = [
                    'medicament' => $medicament,
                    'quantity' => 50, // Quantité par défaut
                    'prix_achat' => $medicament->prix_achat
                ];
            }
        }
    }

    public function removeFromOrder($medicamentId)
    {
        unset($this->selectedMedicaments[$medicamentId]);
    }

    public function updateOrderQuantity($medicamentId, $quantity)
    {
        if (isset($this->selectedMedicaments[$medicamentId])) {
            $this->selectedMedicaments[$medicamentId]['quantity'] = max(1, $quantity);
        }
    }

    public function createOrder()
    {
        $this->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);

        if (empty($this->selectedMedicaments)) {
            session()->flash('error', 'Veuillez sélectionner au moins un médicament.');
            return;
        }

        $total = 0;
        foreach ($this->selectedMedicaments as $item) {
            $total += $item['quantity'] * $item['prix_achat'];
        }

        $commande = CommandeFournisseur::create([
            'fournisseur_id' => $this->fournisseur_id,
            'date_commande' => now(),
            'statut' => 'en_attente',
            'total' => $total,
        ]);

        foreach ($this->selectedMedicaments as $medicamentId => $item) {
            LigneCommande::create([
                'commande_fournisseur_id' => $commande->id,
                'medicament_id' => $medicamentId,
                'quantite' => $item['quantity'],
                'prix_achat' => $item['prix_achat'],
            ]);
        }

        $this->selectedMedicaments = [];
        $this->fournisseur_id = null;
        $this->loadLowStockMedicaments();

        session()->flash('success', 'Commande créée avec succès!');
        $this->dispatch('order-created');
    }

    public function getFilteredMedicamentsProperty()
    {
        $query = Medicament::withSum('lots', 'quantite')
            ->with(['lots' => function($q) {
                $q->orderBy('date_expiration', 'asc');
            }]);

        if ($this->search) {
            $query->where('nom_commercial', 'like', '%' . $this->search . '%')
                  ->orWhere('code_cip13', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('nom_commercial')->get();
    }

    public function getTotalOrderProperty()
    {
        $total = 0;
        foreach ($this->selectedMedicaments as $item) {
            $total += $item['quantity'] * $item['prix_achat'];
        }
        return $total;
    }

    public function render()
    {
        return view('livewire.stock-manager', [
            'medicaments' => $this->filteredMedicaments,
            'totalOrder' => $this->totalOrder,
        ]);
    }
}
