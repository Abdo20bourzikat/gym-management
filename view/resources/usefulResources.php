<?php 
    include '../../model/loginModel.php';
    include '../../model/memberModel.php';
    include '../../model/ressourcesModel.php';
    accessPermission();
    $tabTitle = "Ressources Utiles";
    $pageTitle = "Ressources Utiles";

?>

    <?php include '../../assets/sidebar.php'; ?>

    <div class="container">

        <!-- add new website -->
        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="bi bi-globe fs-5"></i> Nouveau Site
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="col-md-6 shadow-none">
                                    <label for="siteTitle" class="col-md-6 col-form-label text-secondary">Titre de site</label>
                                    <input  type="text" id="siteTitle" name="siteTitle" class="form-control shadow-none" placeholder="titre du site..." required>
                                </div>

                                <?php 
                                    $getGroups = getGroups();                                
                                ?>
                                <div class="col-md-6 shadow-none">
                                    <label class="col-md-6 col-form-label text-secondary">Groupe de site</label>
                                    <select name="siteGroup" class="form-select" required>
                                        <option value="">Choisissez un groupe</option>
                                        <?php foreach ($getGroups as $item): ?>
                                            <option value="<?= $item['id'] ?>"><?= $item['groupname'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12 shadow-none">
                                    <label for="siteDescription" class="col-md-6 col-form-label text-secondary">Description</label>
                                    <textarea id="siteDescription" name="siteDescription" type="text" class="form-control shadow-none" row="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 shadow-none">
                                    <label class="col-md-6 col-form-label text-secondary">Image de site</label>
                                    <input type="file" name="siteImage" class="form-control shadow-none" accept="image/*">
                                </div>
                                <div class="col-md-6 shadow-none">
                                    <label for="siteLink" class="col-md-6 col-form-label text-secondary">Lien de site</label>
                                    <input  type="text" id="siteLink" name="siteLink" class="form-control shadow-none" placeholder="titre du site..." required>
                                </div>
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="saveSite" class="btn btn-primary btn-sm">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Website Modal -->
        <div class="modal fade" id="editSiteModal" tabindex="-1" aria-labelledby="editSiteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editSiteModalLabel">
                            <i class="bi bi-globe fs-5"></i> Modifier le site
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="websiteId" id="editWebsiteId">
                            <div class="row mb-2">
                                <div class="col-md-6 shadow-none">
                                    <label for="siteTitleEdit" class="col-md-6 col-form-label text-secondary">Titre de site</label>
                                    <input type="text" id="siteTitleEdit" name="siteTitle" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 shadow-none">
                                    <label class="col-md-6 col-form-label text-secondary">Groupe de site</label>
                                    <select id="siteGroupEdit" name="siteGroup" class="form-select" required>
                                        <option value=""></option>
                                        <?php foreach ($getGroups as $item): ?>
                                            <option value="<?= $item['id'] ?>"><?= $item['groupname'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12 shadow-none">
                                    <label for="siteDescriptionEdit" class="col-md-6 col-form-label text-secondary">Description</label>
                                    <textarea id="siteDescriptionEdit" name="siteDescription" class="form-control shadow-none" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 shadow-none">
                                    <label class="col-md-6 col-form-label text-secondary">Image de site</label>
                                    <input type="file" name="siteImage" class="form-control shadow-none" accept="image/*">
                                </div>
                                <div class="col-md-6 shadow-none">
                                    <label for="siteLinkEdit" class="col-md-6 col-form-label text-secondary">Lien de site</label>
                                    <input type="text" id="siteLinkEdit" name="siteLink" class="form-control shadow-none" placeholder="titre du site..." required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="updateSite" class="btn btn-primary btn-sm">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- New group modal -->
        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-collection-fill"></i> Nouveau Groupe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-12 shadow-none">
                                    <label for="groupname" class="col-md-6 col-form-label text-secondary">Titre de groupe</label>
                                    <input  type="text" id="groupname" name="groupname" class="form-control shadow-none" placeholder="titre de groupe..." required>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <div style="max-height: 250px; overflow-y: auto; overflow-x: hidden; padding: 10px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Nom de groupe</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php foreach ($getGroups as $group): ?>
                                            <tr>
                                                <td><?= $group['groupname'] ?></td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="groupId" value="<?= $group['id'] ?>">
                                                        <button type="submit" name="deleteSiteGroup" onClick="return (confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?'))"
                                                                class="bg-danger rounded border-0 mx-1" title="Supprimer">
                                                            <i class="bi bi-trash-fill fs-5 mx-1 text-white"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="saveGroup" class="btn btn-success btn-sm">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-5">
                <?php include '../../assets/alert.php'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-3">
                <button type="button" class="btn btn-primary btn-mm shadow-none mx-1" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                    <i class="bi bi-globe"></i> Nouveau Site
                </button>

                <button type="button" class="btn btn-success btn-mm shadow-none" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="bi bi-collection-fill"></i> Nouveau Groupe
                </button>
                <hr>
            </div>
        </div>

        <?php if (count($GetWebsites)): ?>
        
            <div class="row mb-5">

                <?php 
                    $currentGroup = null;
                    foreach ($GetWebsites as $website):

                    if ($currentGroup !== $website['groupname']): 
                        $currentGroup = $website['groupname'];
                ?>
                    <h4 class="mt-4 mb-3">
                        <strong><?= $currentGroup ?></strong>
                    </h4>
                <?php endif; ?>

                <div class="col-md-3">
                    <div class="card shadow position-relative d-flex flex-column">
                        <a href="<?= $website['sitelink'] ?>" target="_blank">
                        <?php if (!empty($website['siteimage'])): ?>
                            <img src="<?= $website['siteimage'] ?>" style="height: 200px;" class="card-img-top" alt="...">
                        <?php else: ?>
                            <div class="card-img-top" style="background-color: gray; height: 200px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-white">No Image</span>
                            </div>
                        <?php endif; ?>
                        </a>

                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-dark"><?= $website['sitetitle'] ?></h5>                            
                            <!-- Set a minimum height for the description to ensure equal height -->
                            <p class="card-text text-dark" style="min-height: 70px;"><?= $website['description'] ?></p>
                            
                            <hr>
                            <div class="d-flex">
                                <button type="button" class="bg-primary rounded border-0" title="Edit" data-bs-toggle="modal" data-bs-target="#editSiteModal" 
                                        onclick="setEditData(<?= htmlspecialchars(json_encode($website, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)) ?>)">

                                    <i class="bi bi-pencil-square fs-5 mx-1 text-white"></i>
                                </button>
                                <form action="" method="post" class="d-inline">
                                    <input type="hidden" name="websiteId" value="<?= $website['id']; ?>">
                                    <button type="submit" name="deleteSite" onClick="return (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?'))"
                                            class="bg-danger rounded border-0 mx-1" title="Supprimer">
                                        <i class="bi bi-trash-fill fs-5 mx-1 text-white"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h5 class="text-secondary m-5 p-5 text-center bg-light">Aucun Site encore</h5>
            <div style="min-height: 200px;"></div>
        <?php endif; ?>

        <?php include('../../assets/footer.php'); ?>

    </div>
</div>

    <script>
        function setEditData(website) {

            // Set the values in the modal fields
            document.getElementById('siteTitleEdit').value = website.sitetitle;

            document.getElementById('siteGroupEdit').value = website.groupid;
            document.getElementById('siteDescriptionEdit').value = website.description;
            document.getElementById('siteLinkEdit').value = website.sitelink;

            // Set the action for the form (if necessary)
            document.getElementById('editWebsiteId').value = website.id;

           
        }
    </script>

</body>
</html>